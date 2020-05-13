@extends("app")
@section('head_title',  $post->title.' | '.get_buzzy_config('sitename'))
@section('head_description', str_limit(str_replace('"', '', $post->body), 150))
@section('head_image', url(makepreview($post->thumb, 'b', 'posts')))
@section('head_url', url( generate_post_url($post) ))
@section('body_class', 'mode-default')
@section("content")

    <div class="content">

        <div class="container">
            <div class="mainside postmainside">

                <div class="post-content" style="margin-top:7px;background: transparent" itemscope="" itemtype="https://schema.org/Article">

                    <div class="post">
                        <div class="post-head">
                            @if($post->approve == 'draft')
                                <div class="label label-staff" >{{ trans('updates.thisdraftpost') }}</div>
                            @endif
                            <h1 itemprop="name" class="post-title">
                                {{ $post->title }}
                            </h1>

                            @can('update', $post)
                                <div style="margin:5px 0">
                                
                                @if($post->approve == 'no')
                                    @can('approve', $post)
                                        <a href="{{ action('Admin\PostsController@approvePost', $post->id) }}" class="button button-orange button-small" ><i class="fa fa-check"></i> {{ trans('index.approve') }}</a>
                                    @else
                                    <a href="#" class="button button-orange button-small" style="cursor: default;height:26px"><i class="fa fa-clock"></i> {{ trans('index.waitapprove') }}</a>
                                    @endcan
                                @endif

                                @can('update', $post)
                                    <a href="{{ action('PostEditorController@showPostEdit', [$post->id]) }}" class="button button-green button-small" ><i class="fa fa-edit"></i>  {{ trans('index.edit') }}</a>
                                @endcan
                                @can('delete', $post)
                                    <a href="{{ action('PostEditorController@deletePost', [$post->id]) }}" onclick="confim()" class="button button-red button-small " ><i class="fa fa-trash"></i></a>
                                @endcan

                                @if($publish_from_now)
                                    <div class="label label-admin" style="margin-left:5px">{{ trans('v3.scheduled_date', ['date' => $post->published_at->format('j M Y, h:i A')]) }}</div>
                                @endif
                                </div>
                            @endcan

                   

                            <p>
                                {!!   nl2br($post->body) !!}
                            </p>
                                <div class="post-head__bar">
                                @if(isset($post->user->username_slug))
                                    <div class="user-info {{ $post->user->genre }} answerer">
                                        <div class="avatar left">
                                            <img src="{{ makepreview($post->user->icon , 's', 'members/avatar') }}" width="45" height="45" alt="{{ $post->user->username }}">
                                        </div>
                                        <div class="info">


                                            <a class="name" href="{{ action('UsersController@index', [$post->user->username_slug ]) }}" target="_self">{{ $post->user->username}}</a>

                                            @if($post->user->usertype == 'Admin')
                                                <div class="label label-admin" style="margin-left:5px">{{ trans('updates.usertypeadmin') }}</div>
                                            @elseif($post->user->usertype == 'Staff')
                                                <div class="label label-staff" style="margin-left:5px">{{ trans('updates.usertypestaff') }}</div>
                                            @elseif($post->user->usertype == 'banned')
                                                <div class="label label-banned" style="margin-left:5px">{{ trans('updates.usertypebanned') }}</div>
                                            @endif




                                            <div class="detail">
                                                {!! trans('index.postedon', ['time' => '<time class="content-info__date" itemprop="datePublished" datetime="'.$post->published_at->toW3cString() .'">'.$post->published_at->diffForHumans() .'</time>' ]) !!}
                                                @if($post->published_at < $post->updated_at)
                                                    <span class="content-info__line">—</span> {!! trans('index.updatedon', ['time' => '<time class="content-info__date" itemprop="dateModified" datetime="'.$post->updated_at->toW3cString() .'">'.$post->updated_at->diffForHumans() .'</time>' ]) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="post-head__meta">
                                    <div class="posted-on">


                                    </div>

                                    <div class="topics-container clearfix">
                                        <div class="item_category">
                                            <?php $postatpe=\App\Categories::byType($post->type)->first();
                                            $postacatpe=getfirstcat($post->categories);
                                            ?>
                                            {!! isset($post->categories) && isset($postacatpe) ? '<a href="'. action('PagesController@showCategory', ['id' => $postacatpe->name_slug ]).'" class="seca"> '.$postacatpe->name. '</a>' : '' !!} {!! isset($postatpe) ? '<a href="'.action('PagesController@showCategory', ['id' => $postatpe->name_slug ]) .'" style="margin-right:5px"> '.$postatpe->name. '</a>' : '' !!}
                                        </div>


                                        <div class="clear"></div>

                                    </div>

                                </div>

                            </div>
                            <div class="clear"></div>
                            @include("_particles.others.postsociallinks")
                            <div class="clear"></div>

                            @foreach(\App\Widgets::where('type', 'PostShareBw')->where('display', 'on')->get() as $widget)
                                {!! $widget->text !!}
                            @endforeach

                        </div>

                        <div class="clear"></div>

                        <article class="post-body" id="post-body" itemprop="text">

                            @include("_particles._lists.entryslists")

                        </article>

                    </div>
                    @if ($post->tags != "")
                        @foreach(explode(',', $post->tags) as $tag)
                          <span class="tagy"><a href="{{ action('PagesController@showtag', $tag) }}"><i class="fa fa-tag"></i> {{$tag}}</a></span>
                        @endforeach
                    @endif


                    @foreach(\App\Widgets::where('type', 'PostBelow')->where('display', 'on')->get() as $widget)
                        {!! $widget->text !!}
                    @endforeach


                </div>

                @include("_forms._reactionforms")

                 @if(isset($commentson))
                    @include("_particles.comments")
                @endif

            </div>
            <div class="sidebar">

                @foreach(\App\Widgets::where('type', 'PostPageSidebar')->where('display', 'on')->get() as $widget)
                    {!! $widget->text !!}
                @endforeach

                <div class="colheader" style="border:0;text-transform: uppercase;">
                    <h1>{{ trans('index.today') }} {!! trans('index.top', ['type' => '<span style="color:#d92b2b">'.trans('index.posts').'</span>' ]) !!}</h1>
                </div>

                @include("_widgets.trendlist_sidebar")

                @include("_widgets.facebooklike")

            </div>
            <div class="clear"></div>
            <br><br> <br>
            @if(isset($lastFeatures))
                @if(count($lastFeatures) >= 3)
                    <div class="colheader">
                        <h1>{{ trans('index.maylike') }}</h1>
                    </div>
                    @include("_widgets.post-between-comments")
                @endif
            @endif
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
    @if($post->type=="poll")
    <script>
        $( document ).ready(function() {
            $('.poll_main_color').each(function(i){
                $(this).css('width', $(this).attr('data-percent')+'%');
            });
        });
    </script>
    @endif
    <script async defer src="//platform.instagram.com/{{  get_buzzy_config('sitelanguage') > "" ? get_buzzy_config('sitelanguage') : 'en_US' }}/embeds.js"></script>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

    <style> .fb_dialog{z-index:999999999} </style>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/{{  get_buzzy_config('sitelanguage') > "" ? get_buzzy_config('sitelanguage') : 'en_US' }}/sdk.js#xfbml=1{!! get_buzzy_config('facebookapp') > "" ? '&appId='.get_buzzy_config('facebookapp') : '' !!}&version=v2.7";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

@endsection