<div class="external-sign-in">

    <span class="sharecount">{{ isset($post->shared->facebook) ? number_format($post->shared->facebook) : 0 }}<br><span>{{trans('updates.shared') }}</span></span>

    <a href="https://www.facebook.com/share.php?u={{ Request::url() }}" data-id="{{ $post->id }}" style="margin-left:0;" rel="fb"  class="Facebook popup-action">{{trans('index.sharefacebook') }}</a>
    <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}&text={{ $post->title }}" data-id="{{ $post->id }}"  class="Twitter popup-action">{{trans('index.sharetweet') }}</a>
    <a href="https://plus.google.com/share?url={{ Request::url() }}" data-id="{{ $post->id }}" class="Google popup-action">{{trans('index.sharegoogle') }}</a>
    <a href="https://reddit.com/submit?url={{ Request::url() }}&title={{ $post->title }}" data-id="{{ $post->id }}" class="Reddit popup-action">{{trans('index.sharereddit') }}</a>

    <div style="display: none">
    <a href="https://pinterest.com/pin/create/link/?url={{ Request::url() }}&media={{ makepreview($post->thumb, 'b', 'posts') }}&description={{ $post->title }}" data-id="{{ $post->id }}" class="Pinterest popup-action">{{trans('index.sharepinterest') }}</a>
    </div>

    <div style="float:right;color:#888;width:60px;text-align:right;font-size:13px;margin-top: 2px">
         <b>{{ isset($post->popularityStats->all_time_stats) ? number_format($post->popularityStats->all_time_stats) : "0" }}</b><br> {{ trans('updates.views') }}
    </div>
</div>