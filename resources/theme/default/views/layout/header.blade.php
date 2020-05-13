<header id="header" class="header">

    <div class="container">
        <div class="header__logo">
            <a href="/" title="">
                <img  class="site-logo" src="{{ asset('assets/images/logo.png') }}" alt="">
            </a>
        </div>
        <div class="header__nav">
            <div class="coltrigger pull-l">
                <a href="javascript:" id="menu-toggler">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div id="colnav" class="toggle-nav pull-l" >
                <ul class="navmenu">
                    @php ($cats = \App\Categories::byMenu()->byActive()->byOrder()->limit(9)->get())
                    @if (count($cats) > 0)
                        @foreach($cats as $categorys)
                        <li class="cats_link" ><a href="{{ url($categorys->name_slug) }}" class="biga firsg" data-type="{{ $categorys->id }}">
                            @if( $categorys->menu_icon_show === 'yes') {!! $categorys->icon !!} @endif
                             {{ trans('index.'.$categorys->name_slug) == 'index.'.$categorys->name_slug ? $categorys->name :  trans('index.'.$categorys->name_slug) }} <i class="fa fa-caret-right"></i></a></li>
                        @endforeach
                    @endif
                    <li class=" " >
                        <div class="search_link">
                            <div class="searchbox_container">
                                <form method="get" action="/search" >
                                    <input type="text" name="q" id="searchbox_text" placeholder="{{ trans('index.search') }}">
                                </form>
                            </div>
                            <a id="searchbutton" href="javascript:"><i class="fa fa-search"></i></a>
                            <a id="searchclosebutton" href="javascript:"><i class="fa fa-close"></i></a>
                        </div>
                    </li>
                </ul>
                <div class="social-side mob">

                    @if(get_buzzy_config('facebookpage'))<a target="_blank" href="{!!  get_buzzy_config('facebookpage') !!}"><i class="fa fa-facebook-square"></i></a> @endif
                    @if(get_buzzy_config('twitterpage'))<a target="_blank" href="{!!  get_buzzy_config('twitterpage') !!}"><i class="fa fa-twitter"></i></a>@endif
                    @if(get_buzzy_config('googlepage'))<a target="_blank" href="{!!  get_buzzy_config('googlepage') !!}"><i class="fa fa-google-plus"></i></a>@endif
                    @if(get_buzzy_config('instagrampage'))<a target="_blank" href="{!!  get_buzzy_config('instagrampage') !!}"><i class="fa fa-instagram"></i></a>@endif
                    <a href="/index.xml"><i class="fa fa-rss"></i></a>

                </div>
            </div>

            <div class="header__usernav">
                @if(Auth::check() and Auth::user()->usertype=='Admin' or get_buzzy_config('UserCanPost') !="no")
                    <div class="create-links hor">
                        <a class="button button-rosy" href="{{ action('PostEditorController@showPostCreate', ['new'=>'news']) }}"><i class="fa fa-plus-circle"></i><b>{{ trans('index.create') }}</b></a>
                    </div>
                @endif
                <ul class="navmenu">
                    @if(Auth::check())
                        <li class="profile-info hor pull-r">
                            <a href="javascript:;" class="user-profile">
                                <img src="{{ makepreview(Auth::user()->icon, 's', 'members/avatar') }}" width="32" height="32"  alt="{{ Auth::user()->username }}">
                                <span class="name"><i class="fa fa-caret-down" style="margin-right:0;"></i> </span>
                            </a>
                            <ul class="sub-nav">
                                <li>
                                    <strong style="display:block;padding:0 15px 10px 10px;font-size:16px;font-weight: 600">{{ Auth::user()->username }}</strong>
                                </li>
                                <li>
                                    <a class="sub-item" href="{{ action('UsersController@index', [ Auth::user()->username_slug ]) }}">{{ trans('index.myprofile') }}</a>
                                </li>
                                <li>
                                    <a class="sub-item" href="{{ action('UsersController@followfeed', ['id' => Auth::user()->username_slug ]) }}">{{ trans('updates.feedposts') }}</a>
                                </li>
                                <li>
                                    <a class="sub-item" href="{{ action('UsersController@draftposts', ['id' => Auth::user()->username_slug ]) }}">{{ trans('index.draft') }}</a>
                                </li>
                                <li>
                                    <a class="sub-item" href="{{ action('UsersController@deletedposts', ['id' => Auth::user()->username_slug ]) }}">{{ trans('index.trash') }}</a>
                                </li>
                                <li>
                                    <a class="sub-item" href="{{ action('UsersController@updatesettings', ['id' => Auth::user()->username_slug ]) }}">{{ trans('index.settings') }}</a>
                                </li>
                                @if(Auth::user()->usertype=='Admin')
                                    <li>
                                        <a class="sub-item" href="/admin">{{ trans('index.adminp') }}</a>
                                    </li>
                                @endif
                                <li>
                                   <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ trans('index.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                            <div class="clear"></div>
                        </li>
                    @else
                        @unless(Request::is('login') or Request::is('register'))
                            <li class="pull-r">
                                <a class="signin_link" href="{{ route('login') }}" rel="get:Loginform"><i class="fa fa-user" style="font-size:20px"></i></a>
                            </li>
                        @endunless
                    @endif

                </ul>
            </div>

            <div class="clear"></div>
        </div>

        <div class="sections" id="sections">
            <div class="scol2 col_sec">
                <div>

                    @foreach(\App\Categories::byMain()->byActive()->orderBy('order')->limit(9)->get() as $cat)
                        <ul id="cats_{{ $cat->id }}">
                                <li>
                                    <a class="biga firsg active"  data-type="{{ $cat->id }}" href="{{ url('/'.$cat->name_slug) }}"> {{ trans('index.'.$cat->name_slug) == 'index.'.$cat->name_slug ? $cat->name :  trans('index.'.$cat->name_slug) }}</a>
                                </li>
                                @foreach(\App\Categories::byType($cat->id)->orderBy('order')->limit(7)->get() as $cata)
                                <li>
                                    <a class="biga"  data-type="{{ $cata->id }}" href="{{ url('/'.$cata->name_slug) }}"> {{ trans('index.'.$cata->name_slug) == 'index.'.$cata->name_slug ? $cata->name :  trans('index.'.$cata->name_slug) }}</a>
                                </li>
                                @endforeach
                        </ul>
                    @endforeach


                </div>
            </div>
            <div class="scol3">
                <div id="catnews_last">

                </div>
                <div class="clear" style="padding:0"></div>
            </div>

        </div>
    </div>
</header>

