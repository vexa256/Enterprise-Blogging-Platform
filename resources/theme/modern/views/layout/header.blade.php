<header class="header">
    <div class="header__searchbar">
        <div class="header__searchbar__container">
            <form action="{{ action('PagesController@search') }}" method="get">
                <input class="header__searchbar__container__input" id="search" type="search" required="" name="q" placeholder="{{ trans('index.search') }}" autocomplete="off">
                <label class="header__searchbar__container__close material-button material-button--icon ripple" for="search"><i class="material-icons">&#xE5CD;</i></label>
            </form>
        </div>
    </div>
    <div class="header__appbar">
        <div class="container">
            <div class="header__appbar--left">
                <div class="header__appbar--left__nav visible-mobile">
                    <i class="material-icons" style="font-weight: 700;">menu</i>
                </div>
                <div class="header__appbar--left__logo"><a href="/"><img  class="site-logo" src="{{ asset('assets/images/logo.png') }}" alt=""></a></div>
                <div class="header__appbar--left__menu hide-mobile">
                    <ul class="header__appbar--left__menu__list">
                        @php ($cats = \App\Categories::byMenu()->byActive()->byOrder()->limit(9)->get())
                        @if (count($cats) > 0)
                            @foreach($cats as $categorys)
                             <li class="header__appbar--left__menu__list__item" >
                                 <a href="{{ url($categorys->name_slug) }}" class="ripple" data-type="{{ $categorys->id }}">
                                @if( $categorys->menu_icon_show === 'yes') {!! $categorys->icon !!} @endif
                                {{ trans('index.'.$categorys->name_slug) == 'index.'.$categorys->name_slug ? $categorys->name :  trans('index.'.$categorys->name_slug) }}
                                </a>
                            </li>
                             @endforeach
                        @endif
                            <li class="header__appbar--left__menu__list__item">
                                <a class="category-dropdown-button ripple has-dropdown" href="javascript:" data-target="category-dropdown" data-align="center">
                                    <i class="material-icons">&#xE5D3;</i>
                                </a>
                                    <div class="category-dropdown dropdown-container">
                                        <div class="category-dropdown_sec sec_cat1 clearfix">
                                            <div class="category-dropdown_community">
                                                <div class="community_title">{{ trans('updates.heycommunity') }}</div>
                                                <div class="community_desc" >  @if(Auth::check()) {!! trans('updates.heycommunitydesc2') !!} @else {!! trans('updates.heycommunitydesc') !!} @endif</div>
                                            </div>

                                            <div class="reaction-emojis">
                                                @php ($reactions = \App\Reaction::where('display', 'on')->orderBy('ord', 'asc')->get())
                                                @if (count($reactions) > 0)
                                                    @foreach($reactions as $reaction)
                                                        <a href="{{ action('PagesController@showReaction', ['reaction' => $reaction->reaction_type] ) }}" title="{{ $reaction->name }}" ><img alt="{{ $reaction->name }}" src="{{ $reaction->icon }} " width="42"></a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="category-dropdown_sec sec_cat2 clearfix">
                                            <ul>
                                                @php ($subcats = \App\Categories::bySub()->byActive()->orderBy('name')->groupBy('name')->get())
                                                @if (count($cats) > 0)
                                                    @foreach($subcats as $cat)
                                                        <li class="dropdown-container__item ripple" style="float:left;width:25%">
                                                            <a href="{{ url($cat->name_slug) }}" title="{{ $cat->name }}">{{ trans('index.'.$cat->name_slug) == 'index.'.$cat->name_slug ? $cat->name :  trans('index.'.$cat->name_slug) }} </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="category-dropdown_sec sec_cat3 clearfix">
                                        <img class="footer-site-logo" src="{{ asset('assets/images/flogo.png') }}" width="60px" alt="">

                                            @if(config('languages.language')!=null)
                                                <div class="language-links hor">
                                                    <a class="button button-white" href="javascript:">
                                                        <i class="material-icons">&#xE8E2;</i> <b>{{ config('languages.language.'.$DB_USER_LANG)['name']  }}</b>
                                                    </a>
                                                    <ul class="sub-nav ">
                                                        @foreach(config('languages.language') as $key => $lang)
                                                            <li>
                                                                <a href="{{ url('/selectlanguge/'.$key) }}" class="sub-item">{{ $lang['name'] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="footer-left">
                                                <div class="footer-menu clearfix">
                                                    @php ($pages = \App\Pages::where('footer', '1')->get())
                                                    @if (count($pages) > 0)
                                                        @foreach($pages as $page)
                                                        <a  class="footer-menu__item " href="{{ action('PagesController@showpage', [$page->slug ]) }}" title="{{ $page->title }}">{{ $page->title }}</a>
                                                        @endforeach
                                                    @endif
                                                    @if(get_buzzy_config('p_buzzycontact') == 'on')
                                                        <a class="footer-menu__item" href="{{ action('ContactController@index') }}">{{ trans('buzzycontact.contact') }}</a>
                                                    @endif
                                                </div>
                                                <div class="footer-copyright clearfix">
                                                    {{ trans("updates.copyright") }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </li>

                    </ul>


                </div>
            </div>
            <div class="header__appbar--right">
                <div class="header__appbar--right__search">
                    <div class="header__appbar--right__search__button material-button material-button--icon ripple"><i class="material-icons">&#xE8B6;</i></div>
                </div>
                <div class="header__appbar--right__notice">

                    @if(Auth::check() and Auth::user()->usertype=='Admin' or get_buzzy_config('UserCanPost') != "no")
                        <div class="create-links hor">
                            <a class="header__appbar--right__settings__button  has-dropdown button button-create hide-mobile" style="margin:-2px 10px 0 8px" href="{{ action('PostEditorController@showPostCreate', ['new'=>'news']) }}" >{{ trans('index.create') }}</a>
                            <a class="header__appbar--right__settings__button material-button material-button--icon ripple visible-mobile" href="{{ action('PostEditorController@showPostCreate', ['new'=>'news']) }}" ><i class="material-icons">&#xE148;</i></a>
                        </div>
                    @endif
                </div>
                @if(Auth::check())
                <div class="header__appbar--right__settings">
                    <div class="header__appbar--right__settings__button material-button material-button--icon ripple has-dropdown" data-target="settings-dropdown" data-align="right-bottom">
                        <img src="{{ makepreview(Auth::user()->icon, 's', 'members/avatar') }}" width="34" height="34"  alt="{{ Auth::user()->username }}">
                    </div>
                    <div class="settings-dropdown dropdown-container" style="width: 150px;">
                        <ul>
                            <li class="dropdown-container__item ripple">
                                <a href="{{ action('UsersController@index', [ Auth::user()->username_slug ]) }}">{{ trans('index.myprofile') }}</a>
                            </li>
                            <li class="dropdown-container__item ripple">
                                <a href="{{ action('UsersController@updatesettings', ['id' => Auth::user()->username_slug ]) }}">{{ trans('index.settings') }}</a>
                            </li>
                            <li class="dropdown-container__item ripple">
                                <a href="{{ action('UsersController@followfeed', ['id' => Auth::user()->username_slug ]) }}">{{ trans('updates.feedposts') }}</a>
                            </li>
                            <li class="dropdown-container__item ripple">
                                <a href="{{ action('UsersController@draftposts', ['id' => Auth::user()->username_slug ]) }}">{{ trans('index.draft') }}</a>
                            </li>
                            <li class="dropdown-container__item ripple">
                                <a href="{{ action('UsersController@deletedposts', ['id' => Auth::user()->username_slug ]) }}">{{ trans('index.trash') }}</a>
                            </li>
                            @if(Auth::user()->usertype=='Admin')
                            <li class="dropdown-container__item ripple">
                                <a href="/admin" target="_blank">{{ trans('index.adminp') }}</a>
                            </li>
                            @endif
                            <li class="dropdown-container__item ripple">
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
                    </div>
                </div>

                @else
                    <div class="header__appbar--right__settings">
                        <a class="header__appbar--right__settings__button material-button material-button--icon ripple"  href="{{ route('login') }}" rel="get:Loginform">
                            <i class="material-icons">&#xE853;</i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</header>

@include('layout.header_mobile')

