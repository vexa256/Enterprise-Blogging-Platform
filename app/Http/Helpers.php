<?php

use App\Post;
use App\User;
use Embed\Embed;
use App\Categories;
use Illuminate\Support\Facades\Storage;

if (!function_exists('makepreview')) {

    function makepreview($img, $type = null, $folder = 'posts')
    {
        if ($type !== null) {
            $type = "-$type.jpg";
        }
        if ($img == null or $img == '') {
            if ($folder === 'members/splash') {
                return asset('assets/images/user-splash' . $type);
            } elseif ($folder === 'members/avatar') {
                return asset('assets/images/user-avatar' . $type);
            }
        } elseif (substr($img, 0, 4) == "http") {
            return $img;
        }

        $path = "/upload/media/" . $folder . "/" . $img . $type;

        if (env('FILESYSTEM_DRIVER') === "s3") {
            return awsurl($path);
        }

        return $path;
    }
}

if (!function_exists('awsurl')) {
    function awsurl($path)
    {
        $path = ltrim($path, '/');
        return env('AWS_URL', '') !== '' ? env('AWS_URL', '') . $path : Storage::disk('s3')->url($path);
    }
}

if (!function_exists('get_post_types')) {
    function get_post_types($option = true)
    {
        $post_types = config('buzzy.post_types');
        foreach ($post_types as $type => $value) {
            if (
                get_buzzy_config('p_buzzynews') != 'on' && $type == 'news'
                || get_buzzy_config('p_buzzylists') != 'on' && $type == 'list'
                || get_buzzy_config('p_buzzyquizzes') != 'on' && $type == 'quiz'
                || get_buzzy_config('p_buzzypolls') != 'on' && $type == 'poll'
                || get_buzzy_config('p_buzzyvideos') != 'on' && $type == 'video'
            ) {
                unset($post_types[$type]);
            } else {
                if ($option) {
                    $post_types[$type] = trans($value['trans']);
                }
            }
        }

        return $post_types;
    }
}


if (!function_exists('get_buzzy_config')) {

    function get_buzzy_config($key, $default = '')
    {
        $value = env('CONF_' . $key);

        if (empty($value)) {
            return $default;
        }

        return $value;
    }
}

if (!function_exists('set_buzzy_config')) {

    function set_buzzy_config($key, $value, $prefix = true)
    {
        if ($prefix) {
            $key = implode('_', ['CONF', $key]);
        }

        if (!empty($value)) {
            $file = \DotenvEditor::setKey($key, $value);
        } else {
            $file = \DotenvEditor::deleteKey($key);
        }

        $file->save();

        return true;
    }
}

if (!function_exists('curlit')) {


    function curlit($site)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $site);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $site = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode != 200) {
            return false;
        }
        return $site;
    }
}


if (!function_exists('get_reaction_user_vote')) {

    function get_reaction_user_vote($post, $type)
    {
        if (!\Auth::check() and get_buzzy_config('sitevoting') == "1") {
            return ' href=' . url('/login') . ' rel="get:Loginform"';
        } else {
            if ($post->reactions()->currentUserHasVoteOnPost($post->id)->count() <= 2) {
                if ($post->reactions()->currentUserHasVoteOnReaction($type)->count() >= 1) {
                    return 'class="off active"  href="javascript:void();"';
                } else {
                    return 'class="postable"  href="javascript:void();" data-method="Post" data-target="reactions' . $post->id . '" data-href="' . action('PollController@VoteReaction', [$post->type, $post->slug, $post->id, 'reaction' => $type]) . '"';
                }
            } else {
                if ($post->reactions()->currentUserHasVoteOnReaction($type)->count() >= 1) {
                    return 'class="off active"  href="javascript:void();"';
                } else {
                    return 'class="off"  href="javascript:void();"';
                }
            }
        }
    }
}

if (!function_exists('parse_main_category')) {
    function parse_main_category($categories)
    {
        if (!is_array($categories)) {
            $categories = json_decode($categories, true);
        }

        $first_cat = reset($categories);

        if (strpos($first_cat, ',') !== false) {
            $exp = explode(',', $first_cat);
            $first_cat = $exp[0];
        }

        return (int) str_replace(",", "", $first_cat);
    }
}

if (!function_exists('generate_post_url')) {


    function generate_post_url($post, $prefix = '')
    {
        $type =  get_buzzy_config('siteposturl', 1);

        if ($type == "" || $type == null || $type == 1 || $type == 2 || $type == 5) {
            $postuffl = $post->slug;

            if ($type == 2) {
                $postuffl = $post->id;
            } elseif ($type == 5) {
                $postuffl = $post->slug . '-' . $post->id;
            }

            if ($post->category_id) {
                $category = Categories::find($post->category_id);
            } else {
                $main_category = parse_main_category($post->categories);
                $category = Categories::find($main_category);
            }

            if ($category) {
                $cat_slug = !empty($category->posturl_slug) ? $category->posturl_slug : $category->name_slug;
            } else {
                $cat_slug = $post->type;
            }

            return url($prefix . '/' . $cat_slug . '/' . $postuffl . '/');
        } elseif ($type == 3 && $post->user) {
            return url($prefix . '/' . $post->user->username_slug . '/' . $post->slug . '/');
        } elseif ($type == 4 && $post->user) {
            return url($prefix . '/' . $post->user->username_slug . '/' . $post->id . '/');
        }

        return url($prefix . '/post/' . $post->id . '/');
    }
}


if (!function_exists('get_post_from_url')) {

    function get_post_from_url($secone, $sectwo)
    {
        $type =  get_buzzy_config('siteposturl', 1);

        if ($type == 1) {
            $post = Post::where('slug', $sectwo)->first();
        } elseif ($type == 2) {
            $post = Post::find($sectwo);
        } elseif ($type == 3) {
            $usera = User::findByUsernameOrFail($secone);
            $post = Post::where('user_id', $usera->id)->where('slug', $sectwo)->first();
        } elseif ($type == 4) {
            $usera = User::findByUsernameOrFail($secone);
            $post = Post::where('user_id', $usera->id)->where('id', $sectwo)->first();
        } elseif ($type == 5) {
            $dilimler = explode("-", $sectwo);
            $last_id = end($dilimler);
            $post = Post::where('id', $last_id)->first();
        }

        return $post;
    }
}

if (!function_exists('rop')) {
    function rop($secone)
    {
        if ($secone == $_SERVER['HTTP_HOST']) {
            return true;
        } else {
            return false;
        }
    }
}



function getInbetweenStrings($start, $end, $str)
{
    $matches = array();
    $regex = "/$start([a-zA-Z0-9_]*)$end/";
    preg_match_all($regex, $str, $matches);
    return $matches[1];
}

if (!function_exists('getfirstcat')) {
    function getfirstcat($catarray)
    {
        if (isset($catarray)) {
            $catarraya = getInbetweenStrings(',', ',"]', $catarray);

            if (empty($catarraya)) {
                $catarraya = getInbetweenStrings('"', ',', $catarray);
            }

            if (isset($catarraya[0])) {
                $firstcat = (int) $catarraya[0];
                $postatpe = Categories::where("id", $firstcat)->first();
                if (isset($postatpe)) {
                    return $postatpe;
                }
            }
        }
        return null;
    }
}


if (!function_exists('get_reaction_icon')) {
    /**
     * Get most voted reaction for post
     *
     * @param $item
     */
    function get_reaction_icon($item, $icon_count = 1)
    {

        $most_reaction = $item->reactions()->get()->pluck('reaction_type')->toArray();

        $most_reaction = array_count_values($most_reaction);

        arsort($most_reaction);

        $most_reaction = array_slice($most_reaction, 0, $icon_count);

        if (isset($most_reaction)) {
            foreach ($most_reaction as $reaction_type => $reaction_count) {
                if ($reaction_count >  get_buzzy_config('showreactioniconon', 100)) {
                    $reaction = \App\Reaction::where('reaction_type', $reaction_type)->first();

                    if (isset($reaction)) {
                        echo '<a href="' . action('PagesController@showReaction', ['reaction' => $reaction_type]) . '" class="badge"><div class="badge-img" style="background-image: none"><img src="' . $reaction->icon . '" style="margin-top:-2px;margin-left:-1px" width="32" height="32"></div></a>';
                    }
                    unset($reaction);
                }
            }

            unset($most_reaction);
        }
    }
}


if (!function_exists('show_headline_posts')) {
    /**
     * Show badges on posts
     *
     * @param $item
     */
    function show_headline_posts($lastFeaturestop, $cat_style = false)
    {

        if ($cat_style) {
            $op_name = 'T_1_CatHeadlineStyle';
        } else {
            $op_name = 'T_1_SiteHeadlineStyle';
        }
        $op_value = get_buzzy_config($op_name);

        if ($op_value != 'off') {
            if ($op_value == 5) {
                echo view('pages.indexheadlines5', ['lastFeaturestop' => $lastFeaturestop]);
            } elseif ($op_value == 4) {
                echo view('pages.indexheadlines4', ['lastFeaturestop' => $lastFeaturestop]);
            } elseif ($op_value == 3) {
                echo view('pages.indexheadlines3', ['lastFeaturestop' => $lastFeaturestop]);
            } elseif ($op_value == 2) {
                echo view('pages.indexheadlines2', ['lastFeaturestop' => $lastFeaturestop]);
            } else {
                echo view('pages.indexheadlines', ['lastFeaturestop' => $lastFeaturestop]);
            }
        }
    }
}

if (!function_exists('parse_post_embed')) {
    /**
     * Show badges on posts
     *
     * @param $item
     */
    function parse_post_embed($url)
    {
        if (!$url) {
            return '';
        }

        // old versions
        if (strpos($url, 'iframe')) {
            return $url;
        }

        try {
            $embed = Embed::create($url);

            if ($embed) {
                return $embed->code;
            }
        } catch (\Exception $e) {
            //
        }

        return $url;
    }
}

/**
 * Credit Wordpress
 *
 * https://github.com/WordPress/WordPress/blob/master/wp-includes/formatting.php
 *
 * @param string slug
 * @return void
 */
function remove_accents($string)
{
    if (!preg_match('/[\x80-\xff]/', $string)) {
        return $string;
    }
 
    $chars = array(
        // Decompositions for Latin-1 Supplement
        '??' => 'a',
        '??' => 'o',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'AE',
        '??' => 'C',
        '??' => 'E',
        '??' => 'E',
        '??' => 'E',
        '??' => 'E',
        '??' => 'I',
        '??' => 'I',
        '??' => 'I',
        '??' => 'I',
        '??' => 'D',
        '??' => 'N',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'U',
        '??' => 'U',
        '??' => 'U',
        '??' => 'U',
        '??' => 'Y',
        '??' => 'TH',
        '??' => 's',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'ae',
        '??' => 'c',
        '??' => 'e',
        '??' => 'e',
        '??' => 'e',
        '??' => 'e',
        '??' => 'i',
        '??' => 'i',
        '??' => 'i',
        '??' => 'i',
        '??' => 'd',
        '??' => 'n',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'u',
        '??' => 'u',
        '??' => 'u',
        '??' => 'u',
        '??' => 'y',
        '??' => 'th',
        '??' => 'y',
        '??' => 'O',
        // Decompositions for Latin Extended-A
        '??' => 'A',
        '??' => 'a',
        '??' => 'A',
        '??' => 'a',
        '??' => 'A',
        '??' => 'a',
        '??' => 'C',
        '??' => 'c',
        '??' => 'C',
        '??' => 'c',
        '??' => 'C',
        '??' => 'c',
        '??' => 'C',
        '??' => 'c',
        '??' => 'D',
        '??' => 'd',
        '??' => 'D',
        '??' => 'd',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'G',
        '??' => 'g',
        '??' => 'G',
        '??' => 'g',
        '??' => 'G',
        '??' => 'g',
        '??' => 'G',
        '??' => 'g',
        '??' => 'H',
        '??' => 'h',
        '??' => 'H',
        '??' => 'h',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'IJ',
        '??' => 'ij',
        '??' => 'J',
        '??' => 'j',
        '??' => 'K',
        '??' => 'k',
        '??' => 'k',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'N',
        '??' => 'n',
        '??' => 'N',
        '??' => 'n',
        '??' => 'N',
        '??' => 'n',
        '??' => 'n',
        '??' => 'N',
        '??' => 'n',
        '??' => 'O',
        '??' => 'o',
        '??' => 'O',
        '??' => 'o',
        '??' => 'O',
        '??' => 'o',
        '??' => 'OE',
        '??' => 'oe',
        '??' => 'R',
        '??' => 'r',
        '??' => 'R',
        '??' => 'r',
        '??' => 'R',
        '??' => 'r',
        '??' => 'S',
        '??' => 's',
        '??' => 'S',
        '??' => 's',
        '??' => 'S',
        '??' => 's',
        '??' => 'S',
        '??' => 's',
        '??' => 'T',
        '??' => 't',
        '??' => 'T',
        '??' => 't',
        '??' => 'T',
        '??' => 't',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'W',
        '??' => 'w',
        '??' => 'Y',
        '??' => 'y',
        '??' => 'Y',
        '??' => 'Z',
        '??' => 'z',
        '??' => 'Z',
        '??' => 'z',
        '??' => 'Z',
        '??' => 'z',
        '??' => 's',
        // Decompositions for Latin Extended-B
        '??' => 'S',
        '??' => 's',
        '??' => 'T',
        '??' => 't',
        // Euro Sign
        '???' => 'E',
        // GBP (Pound) Sign
        '??' => '',
        // Vowels with diacritic (Vietnamese)
        // unmarked
        '??' => 'O',
        '??' => 'o',
        '??' => 'U',
        '??' => 'u',
        // grave accent
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'E',
        '???' => 'e',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'U',
        '???' => 'u',
        '???' => 'Y',
        '???' => 'y',
        // hook
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'E',
        '???' => 'e',
        '???' => 'E',
        '???' => 'e',
        '???' => 'I',
        '???' => 'i',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'U',
        '???' => 'u',
        '???' => 'U',
        '???' => 'u',
        '???' => 'Y',
        '???' => 'y',
        // tilde
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'E',
        '???' => 'e',
        '???' => 'E',
        '???' => 'e',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'U',
        '???' => 'u',
        '???' => 'Y',
        '???' => 'y',
        // acute accent
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'E',
        '???' => 'e',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'U',
        '???' => 'u',
        // dot below
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'A',
        '???' => 'a',
        '???' => 'E',
        '???' => 'e',
        '???' => 'E',
        '???' => 'e',
        '???' => 'I',
        '???' => 'i',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'O',
        '???' => 'o',
        '???' => 'U',
        '???' => 'u',
        '???' => 'U',
        '???' => 'u',
        '???' => 'Y',
        '???' => 'y',
        // Vowels with diacritic (Chinese, Hanyu Pinyin)
        '??' => 'a',
        // macron
        '??' => 'U',
        '??' => 'u',
        // acute accent
        '??' => 'U',
        '??' => 'u',
        // caron
        '??' => 'A',
        '??' => 'a',
        '??' => 'I',
        '??' => 'i',
        '??' => 'O',
        '??' => 'o',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        // grave accent
        '??' => 'U',
        '??' => 'u',
    );

    $chars['??'] = 'Ae';
    $chars['??'] = 'ae';
    $chars['??'] = 'Oe';
    $chars['??'] = 'oe';
    $chars['??'] = 'Ue';
    $chars['??'] = 'ue';
    $chars['??'] = 'ss';
    $chars['??'] = 'Ae';
    $chars['??'] = 'ae';
    $chars['??'] = 'Oe';
    $chars['??'] = 'oe';
    $chars['??'] = 'Aa';
    $chars['??'] = 'aa';
    $chars['l??l'] = 'll';
    $chars['??'] = 'DJ';
    $chars['??'] = 'dj';
    $string = strtr($string, $chars);

    return $string;
}

/**
 * Sanitizes a title, replacing whitespace and a few other characters with dashes.
 *
 * Limits the output to alphanumeric characters, underscore (_) and dash (-).
 * Whitespace becomes a dash.
 *
 * @since 1.2.0
 *
 * @param string $title     The title to be sanitized.
 * @param string $context   Optional. The operation for which the string is sanitized.
 * @return string The sanitized title.
 */
function sanitize_title_with_dashes($title, $context = 'save')
{
    $title = remove_accents($title);
    $title = strip_tags($title);
    // Preserve escaped octets.
    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
    // Remove percent signs that are not part of an octet.
    $title = str_replace('%', '', $title);
    // Restore octets.
    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

    if (function_exists('mb_strtolower')) {
        $title = mb_strtolower($title, 'UTF-8');
    }

    $title = strtolower($title);

    if ('save' == $context) {
        // Convert nbsp, ndash and mdash to hyphens
        $title = str_replace(array('%c2%a0', '%e2%80%93', '%e2%80%94'), '-', $title);
        // Convert nbsp, ndash and mdash HTML entities to hyphens
        $title = str_replace(array('&nbsp;', '&#160;', '&ndash;', '&#8211;', '&mdash;', '&#8212;'), '-', $title);
        // Convert forward slash to hyphen
        $title = str_replace('/', '-', $title);

        // Strip these characters entirely
        $title = str_replace(
            array(
                // soft hyphens
                '%c2%ad',
                // iexcl and iquest
                '%c2%a1',
                '%c2%bf',
                // angle quotes
                '%c2%ab',
                '%c2%bb',
                '%e2%80%b9',
                '%e2%80%ba',
                // curly quotes
                '%e2%80%98',
                '%e2%80%99',
                '%e2%80%9c',
                '%e2%80%9d',
                '%e2%80%9a',
                '%e2%80%9b',
                '%e2%80%9e',
                '%e2%80%9f',
                // copy, reg, deg, hellip and trade
                '%c2%a9',
                '%c2%ae',
                '%c2%b0',
                '%e2%80%a6',
                '%e2%84%a2',
                // acute accents
                '%c2%b4',
                '%cb%8a',
                '%cc%81',
                '%cd%81',
                // grave accent, macron, caron
                '%cc%80',
                '%cc%84',
                '%cc%8c',
            ),
            '',
            $title
        );

        // Convert times to x
        $title = str_replace('%c3%97', 'x', $title);
    }

    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = str_replace('.', '-', $title);

    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');

    return $title;
}
