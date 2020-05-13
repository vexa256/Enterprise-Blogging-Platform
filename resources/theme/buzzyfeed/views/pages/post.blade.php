@extends("app")
@section('head_title',  $post->title.' | '.get_buzzy_config('sitename'))
@section('head_description', str_limit(str_replace('"', '', $post->body), 150))
@section('head_image', url(makepreview($post->thumb, 'b', 'posts')))
@section('head_url', url(generate_post_url($post)))
@section('body_class', 'mode-white')
@section("header")
    @if($post->type == 'news' || $post->type == 'list'  || $post->type == 'video' )
        <link rel="amphtml" href="{{ url('amp/'.$post->type.'/'.$post->id) }}">
    @endif
    <meta property="og:image:width" content="780" />
    <meta property="og:image:height" content="440" />
@endsection
@section("content")
@include('_particles.post_sticky_header')
<div class="buzz-container">
    @include('_particles.ads', ['position' => 'HeaderBelow', 'width' => '728', 'height' => 'auto'])


    <div class="global-container container" style="padding-top:0!important">
        <div class="content"  style=" margin-top:0;padding-top:10px;border-right: 1px solid #e3e3e3;">


            <div class="news content-detail-page">

                @include('pages.postloadpage')

            </div>
            <div class="content-spinner">
                <svg class="spinner-container" width="45px" height="45px" viewBox="0 0 52 52">
                    <circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"></circle>
                </svg>
            </div>
        </div>

        <div class="sidebar hide-mobile">
            <div class="sidebar--fixed">

                @include('_particles.ads', ['position' => 'PostPageSidebar', 'width' => '300', 'height' => 'auto'])


                @include('_sidebar.trending', ['name'=> trans('index.posts')])

                @include('_sidebar.follow')

                @include('_particles.ads', ['position' => 'Footer', 'width' => '300', 'height' => 'auto'])


            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')
    @if($post->type=="quiz")
        <script>
            BuzzyQuizzes = {
                'lang_1': '{{ trans('buzzyquiz.shareonface') }}',
                'lang_2': '{{ trans('buzzyquiz.shareontwitter') }}',
                'lang_3': '{{ trans('buzzyquiz.shareface') }}',
                'lang_4': '{{ trans('buzzyquiz.sharetweet') }}',
                'lang_5': '{{ trans('buzzyquiz.sharedone') }}',
                'lang_6': '{{ trans('buzzyquiz.sharedonedesc') }}'
            };


            $( document ).ready(function() {
                Buzzy.Quizzes.init();
            });
        </script>
    @endif

    <script>
        $( document ).ready(function() {
            $('.poll_main_color').each(function(i){
                $(this).css('width', $(this).attr('data-percent')+'%');
            });
        });
    </script>

    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

    @if(get_buzzy_config('PostPageAutoload') != 'related')
    <script>
        $(function(){
            $(".news").buzzAutoLoad({item: ".news__item"});
        });
    </script>
    @endif

@endsection