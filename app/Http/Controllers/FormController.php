<?php

namespace App\Http\Controllers;

use Embed\Embed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }


    public function addnewform(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        if ($request->query('addnew') == 'text') {
            return view('_forms.__addtextform');
        } elseif ($request->query('addnew') == 'image') {
            return view('_forms.__addimageform');
        } elseif ($request->query('addnew') == 'poll') {
            return view('_forms._buzzypoll.__addpollform');
        } elseif ($request->query('addnew') == 'embed') {
            return view('_forms.__addembedform');
        } elseif ($request->query('addnew') == 'video') {
            return view('_forms.__addvideoform');
        } elseif ($request->query('addnew') == 'tweet') {
            return view('_forms.__addspecialentryform', [
                'typeofwidget' => 'tweet',
                'titleofwidget' => trans('updates.tweet'),
                'iconofwidget' => 'fa-twitter',
                'urlto' => trans('updates.urltotweet'),

            ]);
        } elseif ($request->query('addnew') == 'facebookpost') {
            return view('_forms.__addspecialentryform', [
                'typeofwidget' => 'facebookpost',
                'titleofwidget' => trans('updates.facebookpost'),
                'iconofwidget' => 'fa-facebook',
                'urlto' => trans('updates.urltofacebookpost'),

            ]);
        } elseif ($request->query('addnew') == 'instagram') {
            return view('_forms.__addspecialentryform', [
                'typeofwidget' => 'instagram',
                'titleofwidget' => trans('updates.instagram'),
                'iconofwidget' => 'fa-instagram',
                'urlto' => trans('updates.urltoinstagram'),

            ]);
        } elseif ($request->query('addnew') == 'soundcloud') {
            return view('_forms.__addspecialentryform', [
                'typeofwidget' => 'soundcloud',
                'titleofwidget' => trans('updates.soundcloud'),
                'iconofwidget' => 'fa-soundcloud',
                'urlto' => trans('updates.urltosoundcloud'),

            ]);
        } elseif ($request->query('addnew') == 'question') {
            return view('_forms._buzzyquiz.__addquestionform');
        } elseif ($request->query('addnew') == 'result') {
            return view('_forms._buzzyquiz.__addresultform');
        } elseif ($request->query('addnew') == 'answer') {
            return view('_forms._buzzyquiz.__addanswerform');
        } elseif ($request->query('addnew') == 'pollanswer') {
            return view('_forms._buzzypoll.__addanswerform');
        }
    }


    public function fetchVideoEmbed(Request $request)
    {

        if (!$request->ajax()) {
            return redirect('/');
        }

        $url = $request->input('url');

        // incase if $thumb then tuse save button. we need to save image for that
        try {
            if (!$url) {
                throw new \Exception(trans('updates.BuzzyEditor.lang.lang_11'));
            }

            $embed = Embed::create($url, [
                'min_image_width' => 800,
                'min_image_height' => 400,
                'choose_bigger_image' => true,
                'oembed' => [
                    'parameters' => [],
                    'embedly_key' => 'YOUR_KEY',
                    'iframely_key' => 'YOUR_KEY',
                ]
            ]);

            if (empty($embed->code)) {
                throw new \Exception(trans('updates.BuzzyEditor.lang.lang_11'));
            }

            return [
                'status' => 'success',
                'url' => $embed->url,
                'title' => $embed->title,
                'image' => $embed->image,
                'authorName' => $embed->authorName,
                'html' => $embed->code
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'title' => trans('updates.error'), 'message' => $e->getMessage()];
        }
    }


    public function get_content_data(Request $request)
    {
        $url = $request->input('dataurl');
        try {
            if (!$url) {
                throw new \Exception(trans('updates.BuzzyEditor.lang.lang_11'));
            }

            $homepage = curlit($url);

            if (!$homepage) {
                return array('status' => trans('updates.error'), 'errors' => trans('updates.nodata'));
            }

            $tags = $this->getMetaTags($homepage);

            if (empty($tags)) {
                return array('status' => trans('updates.error'), 'errors' => trans('updates.nodata'));
            }

            preg_match_all('#<p>(.*)</p>#isU', $homepage, $matches);

            $title = null;
            $image = null;
            $description = null;
            $body = null;

            foreach ($matches[0] as $value) {
                $body .= $value;
            }

            if (isset($tags['title'])) {
                $title = $tags['title'];
            } elseif (isset($tags['twitter:title'])) {
                $title = $tags['twitter:title'];
            } elseif (isset($tags['article:title'])) {
                $title = $tags['article:title'];
            }

            if (isset($tags['og:image'])) {
                $image = $tags['og:image'];
            } elseif (isset($tags['twitter:image'])) {
                $image = $tags['twitter:image'];
            } elseif (isset($tags['article:image'])) {
                $image = $tags['article:image'];
            } elseif (isset($tags['image'])) {
                $image = $tags['image'];
            }

            if (isset($tags['og:description'])) {
                $description = $tags['og:description'];
            } elseif (isset($tags['description'])) {
                $description = $tags['description'];
            } elseif (isset($tags['article:description'])) {
                $description = $tags['article:description'];
            }

            $data['headline'] = strip_tags($title);
            $data['description'] = strip_tags($description);
            $data['preview'] = $image;

            $allowed_tags = array(
                "<a>", "<b>", "strong", "<br>", "<span>", "<em>", "<img>", "<hr>", "<i>",
                "<h1>", "<h2>", "<h3>", "<h4>", "<h5>", "<h6>",
                "<li>", "<ol>", "<p>", "<s>", "<span>", "<u>", "<ul>",
                "<code>", "<time>", "<data>", "<abbr>", "<dfn>", "<q>", "<cite>", "<s>", "<small>",
                "<strong>", "<em>", "<a>", "<div>", "<figcaption>", "<figure>", "<dd>", "<dt>",
                "<dl>",  "<blockquote>", "<pre>", "<address>",
                "<th>", "<td>", "<tr>", "<tfoot>", "<thead>", "<tbody>",
            );

            $entry = new \stdClass();
            $entry->title = $title;
            $entry->body = strip_tags($body, implode('', $allowed_tags));

            $data['entries'] = view('_forms.__addtextform')->with(compact('entry'))->render();

            return $data;
            
        } catch (\Exception $e) {
            return ['status' => 'error', 'title' => trans('updates.error'), 'error' => $e->getMessage()];
        }
    }


    public function getMetaTags($str)
    {
        $pattern = '
      ~<\s*meta\s

      # using lookahead to capture type to $1
        (?=[^>]*?
        \b(?:name|property|http-equiv)\s*=\s*
        (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
        ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
      )

      # capture content to $2
      [^>]*?\bcontent\s*=\s*
        (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
        ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
      [^>]*>

      ~ix';

        if (preg_match_all($pattern, $str, $out))
            return array_combine($out[1], $out[2]);
        return array();
    }
}
