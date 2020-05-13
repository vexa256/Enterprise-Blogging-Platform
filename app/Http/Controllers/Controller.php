<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use YAAP\Theme\Facades\Theme;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Theme::init(get_buzzy_config('CurrentTheme', 'modern'));

        $locale = Cookie::get('buzzy_locale');

        if (!$locale || !array_key_exists($locale, config('languages.language'))) {
            $locale = get_buzzy_config('sitedefaultlanguage', 'en');
        }

        Carbon::setLocale($locale);
        app()->setLocale($locale);

        \View::share(
            [
                'DB_USER_LANG' => $locale
            ]
        );
    }

    public function get_app_theme()
    {
        $theme = get_buzzy_config('CurrentTheme', 'modern');

        if (env('APP_DEMO')) {
            $theme_req = request()->get('theme');

            if ($theme_req && in_array($theme_req, ['modern', 'buzzyfeed', 'boxed', 'viralmag', 'default'])) {
                Cookie::queue('buzzy_theme', $theme_req, 9999999, '/');
                $theme = $theme_req;
            } else {
                $theme = Cookie::get('buzzy_theme');
                $theme = decrypt($theme);
            }
        }

        return $theme;
    }
}
