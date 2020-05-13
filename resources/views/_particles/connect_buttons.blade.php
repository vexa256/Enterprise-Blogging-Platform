@if(get_buzzy_config('facebookapp') or get_buzzy_config('googleapp') or get_buzzy_config('twitterapp'))
<div class="login-container steps">
    <div class="connect-forms ">
        <div class="hdr">{{ trans('index.connect') }}</div>
        <div class="external-sign-in">
            @if(get_buzzy_config('facebookapp'))
            <a class="Facebook do-signup" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'facebook']) }}"><div class="buzz-icon buzz-facebook-big"></div>{{ trans('index.connectfacebok') }}</a>
            <a class="Facebook mini" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'facebook']) }}"><div class="buzz-icon buzz-facebook-big"></div></a>
            @endif
            @if(get_buzzy_config('googleapp'))
            <a class="Google do-signup " href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'google']) }}"><div class="buzz-icon buzz-google-big"></div>{{ trans('index.connectgoogle') }}</a>
            <a class="Google mini" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'google']) }}"><div class="buzz-icon buzz-google-big"></div></a>
            @endif
            @if(get_buzzy_config('twitterapp'))
            <a class="Twitter do-signup " href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'twitter']) }}"><div class="buzz-icon buzz-twitter-big"></div>{{ trans('index.connecttwitter') }}</a>
            <a class="Twitter mini" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'twitter']) }}"><div class="buzz-icon buzz-twitter-big"></div></a>
            @endif
            @if(env('VKONTAKTE_KEY'))
            <a class="Vkontakte do-signup" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'vkontakte']) }}"><div class="buzz-icon buzz-vkontakte-big"></div>{{ trans('updates.connectvkontakte') }}</a>
           <a class="Vkontakte mini" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'vkontakte']) }}"><div class="buzz-icon buzz-vkontakte-big"></div></a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>
@endif