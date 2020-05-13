<div class="content-comments">
    @if(get_buzzy_config('p-easycomment')=='on')
            <!-- easyComment Content Div -->
    <div id="easyComment_Content"></div>
    <br><br>
    <!-- easyComment -->
    <script type="text/javascript">
        // CONFIGURATION VARIABLES
        var easyComment_ContentID = 'Post_{{ $post->id }}';
        var easyComment_FooterLinks = 'Off'; // Disable footer links from the easyComment script for Buzzy Demo

        /* * * DON'T EDIT BELOW THIS LINE * * */
        var easyComment_Theme = '{{ get_buzzy_config("easyCommentTheme", "Default") }}';
        var easyComment_Title = '{{ get_buzzy_config("easyCommentTitle", trans("index.conversations")) }}';

        var easyComment_userid = '{{ Auth::check() ? Auth::user()->id : '' }}';
        var easyComment_username = '{{ Auth::check() ? Auth::user()->username : '' }}';
        var easyComment_usericon = '{{ Auth::check() ? url(makepreview(Auth::user()->icon, "s", "members/avatar")) : url(makepreview('', "s", "members/avatar")) }}';
        var easyComment_profillink = '{{ Auth::check() ? action("UsersController@index", [Auth::user()->username_slug ]) : '' }}';

        var easyComment_Domain = '{{ get_buzzy_config("easyCommentcode", url("/comments/")) }}';

        (function() {
            var EC = document.createElement('script');
            EC.type = 'text/javascript';
            EC.async = true;
            EC.src = easyComment_Domain + 'plugin/embed.js';

            (document.head || document.body).appendChild(EC);
        })();
    </script>

    @endif

    @if(get_buzzy_config('p_facebookcomments')=='on')
        <div class="colheader ">
            <h1>{{ trans('index.conversations') }}</h1>
        </div>

        <div class="fb-comments" ref="{{ generate_post_url($post) }}" data-numposts="5" data-width="100%" style="width: 100%"></div>

        <style>.fb-comments{  width: 102%;}.fb-comments iframe{margin:-7px;    width: 102%;}</style>
        <br><br>
    @endif
    @if(get_buzzy_config('p_disquscomments')=='on')
        <div class="colheader ">
            <h1>{{ trans('index.disqusconversations') }}</h1>
        </div>
        <div id="disqus_thread"></div>
        <script>
                var disqus_config = function () {
                this.page.url = "{{ generate_post_url($post) }}";  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = "{{ $post->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
            (function() {  // DON'T EDIT BELOW THIS LINE


                var d = document, s = d.createElement('script');

                s.src = '//{!! get_buzzy_config("DisqussCommentcode") !!}.disqus.com/embed.js';

                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
        <br><br>
    @endif
 
</div>