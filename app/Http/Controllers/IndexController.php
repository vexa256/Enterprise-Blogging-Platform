<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function index()
    {
        $homepagebuilder = get_buzzy_config('p_homepagebuilder');
        $CurrentTheme = get_buzzy_config('CurrentTheme');

        $HomeColSec1Tit1 = null;
        $HomeColSec2Tit1 = null;
        $HomeColSec3Tit1 = null;
        $HomeColSec1Type1 = null;
        $HomeColSec2Type1 = null;
        $HomeColSec3Type1 = null;
        if ($homepagebuilder == "on") {
            $HomeColSec1Tit1 = get_buzzy_config('HomeColSec1Tit1');
            $HomeColSec2Tit1 = get_buzzy_config('HomeColSec2Tit1');
            $HomeColSec3Tit1 = get_buzzy_config('HomeColSec3Tit1');
            $HomeColSec1Type1 = get_buzzy_config('HomeColSec1Type1');
            $HomeColSec2Type1 = get_buzzy_config('HomeColSec2Type1');
            $HomeColSec3Type1 = get_buzzy_config('HomeColSec3Type1');
        }
        //set default
        if ($HomeColSec1Type1 == null) {
            $HomeColSec1Type1 = config('buzzytheme_' . $CurrentTheme . '.HomeColSec1Type1') !== null ? config('buzzytheme_' . $CurrentTheme . '.HomeColSec1Type1') : '["list", "quiz"]';
        }
        if ($HomeColSec2Type1 == null) {
            $HomeColSec2Type1 = config('buzzytheme_' . $CurrentTheme . '.HomeColSec2Type1') !== null ? config('buzzytheme_' . $CurrentTheme . '.HomeColSec2Type1') : '["news"]';
        }
        if ($HomeColSec3Type1 == null) {
            $HomeColSec3Type1 = config('buzzytheme_' . $CurrentTheme . '.HomeColSec3Type1') !== null ? config('buzzytheme_' . $CurrentTheme . '.HomeColSec3Type1') : '["video"]';
        }

        //colums 1
        $lastFeatures = Post::forHome()->acceptedTypes($HomeColSec1Type1)->activeTypes()->approve('yes')->byPublished()->paginate(10);

        //colums 2
        $lastNews = Post::forHome()->acceptedTypes($HomeColSec2Type1)->activeTypes()->approve('yes')->byPublished()->paginate(config('buzzytheme_' . $CurrentTheme . '.homepage_news_limit'));

        //colums 3
        $lastTrendingVideos = Post::forHome()->acceptedTypes($HomeColSec3Type1)->activeTypes()->approve('yes')->byPublished()->take(10)->get();

        $lastFeaturestop = Post::forHome('Features')->activeTypes()->approve('yes')->byPublished()->where("featured_at", '>', '')->latest("featured_at")->take(10)->get();

        $lastvideoscol1  = Post::forHome()->byType('video')->activeTypes()->approve('yes')->byPublished()->getStats('one_day_stats', 'DESC')->paginate(3);

        $lastpoll        = Post::forHome()->byType('poll')->activeTypes()->approve('yes')->byPublished()->paginate(2);

        $lastTrending    = Post::forHome()->activeTypes()->approve('yes')->byPublished()->getStats('one_day_stats', 'DESC', 10)->get();

        if (\Request::query('page')) {
            if (\Request::ajax()) {
                if (\Request::query("timeline") == "right") {
                    return view('pages.indexrightpostloadpage', compact('lastNews'));
                } else {
                    return view('pages.indexpostloadpage', compact('lastFeatures', 'lastvideoscol1', 'lastpoll'));
                }
            } else {
                return redirect('/');
            }
        } else {
            if (Post::count() < 1) {
                return view('errors.starting');
            }
        }

        return view('pages.index', compact('lastFeaturestop', 'lastFeatures', 'lastvideoscol1', 'lastpoll', 'lastNews', 'lastTrending', 'lastTrendingVideos', 'HomeColSec1Tit1', 'HomeColSec2Tit1', 'HomeColSec3Tit1'));
    }


    /**
     * Show a Amp Post
     *
     * @return \Illuminate\View\View
     */
    public function amp()
    {
        $lastFeaturestop = Post::forhome('Features')->where('type', '!=', 'quiz')->where('type', '!=', 'poll')->activeTypes()->approve('yes')->where("featured_at", '>', '')->latest("featured_at")->take(10)->get();
        //colums 2
        $lastNews =   Post::forhome()->where('type', '!=', 'quiz')->where('type', '!=', 'poll')->activeTypes()->approve('yes')->byPublished()->paginate(10);

        return view('amp.index', compact('lastFeaturestop',  'lastNews'));
    }


    public function changeLanguage($locale)
    {
        if (array_key_exists($locale, config('languages.language'))) {
            Cookie::queue('buzzy_locale', $locale, 9999999, '/');
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}
