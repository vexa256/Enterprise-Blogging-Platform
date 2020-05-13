@extends("app")
@section('header')
        <link rel="amphtml" href="{{ url('amp') }}">
@endsection
@section("content")
<div class="clearfix">
{{ show_headline_posts($lastFeaturestop) }}

@include('_particles.ads', ['position' => 'HeaderBelow', 'width' => '728', 'height' => 'auto'])

    <div class="colheader sea">
        <h1>{{ $HomeColSec1Tit1 > "" ? $HomeColSec1Tit1 :  trans('index.latest', ['type' => trans('index.lists') ]) }}</h1>
    </div>

    @if($lastFeatures)
    <div class="content-timeline__list clearfix">

        @include('pages.indexpostloadpage')

    </div>
    @endif
    <div class="content-timeline__more">
        <i class="content-timeline__more__icon material-icons">&#xE5D5;</i>
        <span class="content-timeline__more__text">{{ trans('updates.loadmore') }}</span>
    </div>
    <div class="content-spinner">
        <svg class="spinner-container" width="45px" height="45px" viewBox="0 0 52 52">
            <circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"></circle>
        </svg>
    </div>

@include('_particles.ads', ['position' => 'Footer', 'width' => '728', 'height' => 'auto'])
</div>

@endsection
@section('footer')
<script>

     $(document).ready(function() {
       $('.content-timeline__item').buzzTimeline({
            header: '.header',
            container: '.content-timeline__list',
            spinner: '.content-spinner',
            loadMore: '.content-timeline__more',
            path: '/',
            limit: 3,
            filterType: 'right'
        });

    });
</script>

@endsection