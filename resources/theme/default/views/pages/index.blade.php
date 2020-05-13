@extends("app")
@section('header')
    <link rel="amphtml" href="{{ url('amp') }}">
@endsection
@section("content")
@unless(count($lastFeaturestop)==0)
<div class="content shay">
    <div class="container shay">
        <div class="row homefeatures clearfix">
            <div class="pull-l">
                @foreach($lastFeaturestop->slice(0,1) as $item)
                    <div class="tile tile-2">
                        @include('._particles._lists.features_list', ['descof' => 'on','metaon' => 'on'])

                    </div>
                @endforeach

            </div>
            <div class="pull-l">
                @foreach($lastFeaturestop->slice(1,1) as $item)
                    <div class="tile tile-1">
                        @include('._particles._lists.features_list', ['descof' => 'on','metaon' => 'on'])
                    </div>
                @endforeach

            </div>

            <div class="pull-l tway">
                @foreach($lastFeaturestop->slice(2,2) as $item)
                    <div class="tile tile-3">
                        @include('._particles._lists.features_list', ['metaon' => 'on'])

                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endunless

<div class="content">

    <div class="container">



        <div class="row homecolums">
            <div class="column1 ">
                <div class="colheader sea">
                    <h1>{{ $HomeColSec1Tit1 > "" ? $HomeColSec1Tit1 :  trans('index.latest', ['type' => trans('index.lists') ]) }}</h1>
                </div>
                <div class="jscroll" data-auto="{!!  get_buzzy_config('AutoLoadLists')=='yes' ?: 'false' !!}">
                @include('pages.indexpostloadpage')
                </div>
            </div>

            <div class="column2">
                <div class="colheader formula">
                    <h1>{{ $HomeColSec2Tit1 > "" ? $HomeColSec2Tit1 : trans('index.latest', ['type' => trans('index.news') ]) }}</h1>
                </div>

                    @include('pages.indexrightpostloadpage')

            </div>
            <div class="column3">
                @if(get_buzzy_config('HomeCol3Trends')!=='false')
                <div class="coltrend">
                <div class="colheader trend">
                    <h1>{{  trans('index.trendings') }}</h1>
                </div>
                @if(isset($lastTrending))
                    <ul class="items_lists">
                        @foreach($lastTrending as $item)

                            @include('._particles._lists.items_list', ['listtype' => 'captionlist list-count tits', 'descof' => 'off','metaof' => 'off', 'linkcolor' => 'white'])
                        @endforeach
                    </ul>
                @endif
                </div>
                @endif
                     <div class="coltrend">
                <div class="colheader darken">
                    <h1>{{ $HomeColSec3Tit1 > "" ? $HomeColSec3Tit1 : trans('index.latest', ['type' => trans('index.videos') ]) }}</h1>
                </div>
                @if(isset($lastTrendingVideos))
                    <ul class="items_lists">
                        @foreach($lastTrendingVideos as $item)
                            @include('._particles._lists.items_list', ['listtype' => 'big_image small-h bolb tits', 'video' => 'on', 'setmediamarginbottom' => '5px', 'descof' => 'off', 'metaof' => 'off', 'linkcolor' => 'default'])
                        @endforeach
                    </ul>
                @endif
                </div>
                <div class="social-side">
                    <div class="colheader rosy">
                        <h1>{{ trans('index.connect') }}</h1>
                    </div>
                    <div class="external-sign-in" style="padding-top:0">
                        @if(get_buzzy_config('facebookpage'))
                            <a class="Facebook mini" target=_blank href="{!!  get_buzzy_config('facebookpage') !!}"></a>
                        @endif
                        @if(get_buzzy_config('twitterpage'))
                            <a class="Twitter mini" target=_blank href="{!!  get_buzzy_config('twitterpage') !!}"></a>
                        @endif
                        @if(get_buzzy_config('googlepage'))
                            <a class="Google mini"  target=_blank href="{!!  get_buzzy_config('googlepage') !!}"></a>
                        @endif
                        @if(get_buzzy_config('instagrampage'))
                            <a class="Instagram mini"  target=_blank href="{!!  get_buzzy_config('instagrampage') !!}"></a>
                        @endif
                         <a class="Rss mini"  target=_blank href="index.xml"></a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
