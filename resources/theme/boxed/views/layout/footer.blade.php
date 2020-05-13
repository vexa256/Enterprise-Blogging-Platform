<span class="back-to-top hide-mobile"><i class="material-icons">&#xE316;</i></span>

<div class="clear"></div>
<footer class="footer-bottom category-dropdown_sec sec_cat3 clearfix clearfix">
    <div class="container" >
        <img class="footer-site-logo" src="{{ asset('assets/images/flogo.png') }}" width="60px" alt="">

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
    </div>
</footer>

