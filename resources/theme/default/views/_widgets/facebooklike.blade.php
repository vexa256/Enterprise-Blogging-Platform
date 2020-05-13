@if(get_buzzy_config('facebookpage') or get_buzzy_config('twitterpage') or get_buzzy_config('googlepage') or get_buzzy_config('instagrampage'))
    <div class="external-sign-in" style="margin-bottom:20px">

    <div class="colheader" style="text-align: center;margin-bottom:20px;margin-top:-10px">
        <h1 style="float: none;position:relative;bottom:-15px;padding:0 10px;background-color: #fff;display: inline-block;"></h1>
    </div>
    @if(get_buzzy_config('facebookpage'))
    <a class="Facebook do-signup tgec" target=_blank href="{!!  get_buzzy_config('facebookpage') !!}">{{ trans('index.likeonface') }} </a>
    @endif
    @if(get_buzzy_config('twitterpage'))
    <a class="Twitter do-signup tgec" target=_blank href="{!!  get_buzzy_config('twitterpage') !!}">{{ trans('index.followontwitter') }}</a>
    @endif
    @if(get_buzzy_config('googlepage'))
    <a class="Google do-signup tgec" target=_blank href="{!!  get_buzzy_config('googlepage') !!}">{{ trans('index.followongoogle') }}</a>
    @endif
    @if(get_buzzy_config('instagrampage'))
    <a class="Instagram do-signup tgec" target=_blank href="{!!  get_buzzy_config('instagrampage') !!}">{{ trans('index.followoninstagram') }}</a>
    @endif
</div>
@endif