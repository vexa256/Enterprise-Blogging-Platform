<!doctype html>
<html lang="{{ Lang::getLocale() }}">
<head>
    <title>@yield('head_title', get_buzzy_config('sitetitle'))</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))" />

    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('head_title',  get_buzzy_config('sitetitle'))" />
    <meta property="og:description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))" />
    <meta property="og:image" content="@yield('head_image', asset('assets/images/logo.png'))" />
    <meta property="og:url" content="@yield('head_url', url('/'))" />

    <meta name="twitter:image" content="@yield('head_image', asset('assets/images/logo.png'))" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="@yield('head_url', url('/'))">
    <meta name="twitter:title" content="@yield('head_title',  get_buzzy_config('sitetitle'))">
    <meta name="twitter:description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))">

    <link href='https://fonts.googleapis.com/css?family={{  get_buzzy_config('googlefont') }}' rel='stylesheet' type='text/css'>
    <link href="{{ url('/images/favicon.png') }}" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset('/css/style.css', null, false) }}">

    @include("style")

    {!!  rawurldecode(get_buzzy_config('headcode'))  !!}
    @yield("header")

</head>
<?php $DB_USER_LANG = isset($DB_USER_LANG) ? $DB_USER_LANG : '' ?>
<body class="{{ get_buzzy_config('languagetype') }} {{ config('languages.language.'.$DB_USER_LANG)['rtl'] ? 'rtl' :''  }} {{ config('languages.language.'.\Session::get('locale'))['wideheader'] ? 'widecontainer' : ''  }}  {{ get_buzzy_config('LayoutType') }} {{ get_buzzy_config('NavbarType') }} @yield("body_class") @yield("modeboxed") ">
@include("layout.header")

<div class="content-wrapper" id="container-wrapper">
    @if(!Request::is('create') ) @if(Request::segment(1)!=='profile') @if(Request::segment(1)!=='edit')
            @foreach(\App\Widgets::where('type', 'HeaderBelow')->where('display', 'on')->get() as $widget)
                <div class="content">
                    <div class="container" style="text-align: center;padding-top:20px;padding-bottom:20px ">
                        <center>
                         {!! $widget->text !!}
                        </center>
                    </div>
                </div>
            @endforeach
    @endif @endif @endif
    @yield("content")

</div>

@include("layout.footer")

<div id="fb-root"></div>

<script src="{{ asset('assets/js/manifest.js') }}"></script>
<script src="{{ asset('assets/js/vendor.js') }}"></script>
<script src="{{ Theme::asset('js/app.min.js', null, false) }}"></script>


@yield("footer")
@include('.errors.swalerror')

<div id="auth-modal" class="modal auth-modal"></div>

<div class="hide">
    <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
</div>

{!!  rawurldecode(get_buzzy_config('footercode'))  !!}

</body>
</html>