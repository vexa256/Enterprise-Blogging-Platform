<!doctype html>
<html lang="{{ Lang::getLocale() }}"{{ config('languages.language.'.$DB_USER_LANG.'.rtl') == true ? ' dir=rtl' : '' }}>
<head>
    <title>@yield('head_title', get_buzzy_config('sitetitle'))</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))" />
    <meta property="fb:app_id" content="{{  get_buzzy_config('facebookapp') }}" />
    <meta property="og:type" content="@yield('og_type',  'website')" />
    <meta property="og:site_name" content="{{  str_replace(' ', '', get_buzzy_config('sitename')) }}">
    <meta property="og:title" content="@yield('head_title',  get_buzzy_config('sitetitle'))">
    <meta property="og:description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))">
    <meta property="og:url" content="@yield('head_url', url('/'))">
    <meta property="og:locale" content="{{  get_buzzy_config('sitelanguage') }}">
    <meta property="og:image" content="@yield('head_image', asset('assets/images/logo.png'))" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{ str_replace(' ', '', get_buzzy_config('sitename')) }}">
    <meta name="twitter:title" content="@yield('head_title',  get_buzzy_config('sitetitle'))">
    <meta name="twitter:url" content="@yield('head_url', url('/'))">
    <meta name="twitter:description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))">
    <meta name="twitter:image" content="@yield('head_image', asset('assets/images/logo.png'))" />
    <link rel="shortcut icon" href="{{ url('/images/favicon.png') }}" />

    <link href='https://fonts.googleapis.com/css?family={{  get_buzzy_config('googlefont') }}' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{  asset('assets/css/plugins.css') }}">
    <?php
    $googlefont_prefix =  config('languages.language.'.$DB_USER_LANG.'.rtl') == true ? '-rtl' : '';
    ?>
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/application'. $googlefont_prefix .'.css', null, false) }}">
    <link rel="stylesheet" href="{{ Theme::asset('/css/style.css', null, false) }}">

    @include("style")

    {!! rawurldecode(get_buzzy_config('headcode')) !!}

    @yield("header")

</head>
<body class="@yield('body_class') ">
<div id="fb-root"></div>
@include("layout.header")

@yield("content")

@include("layout.footer")

<script src="{{ asset('assets/js/manifest.js') }}"></script>
<script src="{{ asset('assets/js/vendor.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

@if(get_buzzy_config('facebookapp')>"")
<script>
    $(function(){

        //facebook
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ get_buzzy_config('facebookapp') }}',
                xfbml      : true,
                version    : 'v2.5'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/{{  get_buzzy_config('sitelanguage') > "" ? get_buzzy_config('sitelanguage') : 'en_US' }}/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    });
</script>
@endif
@yield("footer")
@include('.errors.swalerror')

<div id="auth-modal" class="modal auth-modal"></div>

<div class="hide">
    <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
</div>

{!!  rawurldecode(get_buzzy_config('footercode'))  !!}

</body>
</html>


