@if(get_buzzy_config('facebookpage') or get_buzzy_config('twitterpage') or get_buzzy_config('googlepage') or get_buzzy_config('instagrampage'))
    <div class="sidebar-block clearfix">
        <div class="colheader sea"  style="margin:0px">
            <h1>{{ trans('index.ccommunity') }}</h1>
        </div>
        <div class="external-sign-in">

            @if(get_buzzy_config('facebookpage'))
                <a class="Facebook do-signup tgec" target=_blank href="{!!  get_buzzy_config('facebookpage') !!}"><div class="buzz-icon buzz-facebook-big"></div> {{ trans('index.likeonface') }} </a>
            @endif
            @if(get_buzzy_config('twitterpage'))
                <a class="Twitter do-signup tgec" target=_blank href="{!!  get_buzzy_config('twitterpage') !!}"><div class="buzz-icon buzz-twitter-big"></div>{{ trans('index.followontwitter') }}</a>
            @endif
            @if(get_buzzy_config('googlepage'))
                <a class="Google do-signup tgec" target=_blank href="{!!  get_buzzy_config('googlepage') !!}"><div class="buzz-icon buzz-google-big"></div>{{ trans('index.followongoogle') }}</a>
            @endif
            @if(get_buzzy_config('instagrampage'))
                <a class="Instagram do-signup tgec" target=_blank href="{!!  get_buzzy_config('instagrampage') !!}"><div class="buzz-icon buzz-ingtagram-big"></div>{{ trans('index.followoninstagram') }}</a>
            @endif
        </div>
      </div>
    @endif
