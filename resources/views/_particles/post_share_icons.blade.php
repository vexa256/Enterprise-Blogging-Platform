
<div class="content-share">
    <a class="content-share__item facebook buzz-share-button" data-share-type="facebook" data-type="news" data-id="{{ $post->id }}" data-post-url="/shared" data-title="{{ $post->title }}" data-sef="{{  generate_post_url($post) }}">
        <div class="content-share__icon facebook-white"></div>
        @if(isset($post->shared->facebook))
            <div class="content-share__badge buzz-share-badge-facebook {{ $post->shared->facebook > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->facebook }}</div>
        @endif
    </a>
    <a class="content-share__item twitter buzz-share-button" data-share-type="twitter" data-type="news" data-id="{{ $post->id }}" data-post-url="/shared" data-title="{{ $post->title }}" data-sef="{{  generate_post_url($post)  }}">
        <div class="content-share__icon twitter-white"></div>
        @if(isset($post->shared->twitter))
            <div class="content-share__badge buzz-share-badge-twitter {{ $post->shared->twitter > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->twitter }}</div>
        @endif
    </a>
    <a class="content-share__item gplus buzz-share-button" data-type="news" data-id="{{ $post->id }}" data-share-type="gplus" data-post-url="/shared" data-title="{{ $post->title }}" data-sef="{{ generate_post_url($post) }}">
        <div class="content-share__icon gplus-white"></div>
        @if(isset($post->shared->gplus))
            <div class="content-share__badge buzz-share-badge-gplus {{ $post->shared->gplus > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->gplus }}</div>
        @endif
    </a>
    <a class="content-share__item whatsapp buzz-share-button visible-phone" data-type="news" data-id="{{ $post->id }}" data-share-type="whatsapp" data-post-url="/shared" data-title="{{ $post->title }}" data-sef="{{  generate_post_url($post) }}">
        <div class="content-share__icon whatsapp-white"></div>
        @if(isset($post->shared->whatsapp))
            <div class="content-share__badge buzz-share-badge-whatsapp {{ $post->shared->whatsapp > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->whatsapp }}</div>
        @endif
    </a>
    <a class="content-share__item mail buzz-share-button" data-type="news" data-id="{{ $post->id }}" data-share-type="mail" data-post-url="/shared" data-title="{{ $post->title }}" data-sef="{{   generate_post_url($post) }}">
        <div class="content-share__icon mail-white"></div>
        @if(isset($post->shared->mail))
            <div class="content-share__badge buzz-share-badge-mail {{ $post->shared->mail > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->mail }}</div>
        @endif
    </a>
    <div class="content-font hide-phone">
        <div class="content-font__item has-dropdown" data-target="font-dropdown-{{ $post->id }}" data-align="left-bottom">
            <span class="content-font__icon"></span>
        </div>
        <div class="font-dropdown font-dropdown-{{ $post->id }} dropdown-container">
            <ul>
                <li class="font-dropdown__item dropdown-container__item ripple has-ripple" data-action="minus">
                    <span class="font-dropdown__item__icon font-dropdown__item__icon--minus"></span>
                </li>
                <li class="font-dropdown__item dropdown-container__item ripple has-ripple" data-action="plus">
                    <span class="font-dropdown__item__icon font-dropdown__item__icon--plus"></span>
                </li>
            </ul>
        </div>
    </div>
    @if(isset($show_views))
     <div class="content-share__view hide-phone" style="float:right;color:#888;width:60px;text-align:right;font-size:13px;margin-top: 2px">
        <b>{{ isset($post->popularityStats->all_time_stats) ? number_format($post->popularityStats->all_time_stats) : "0" }}</b><br> {{ trans('updates.views') }}
    </div>
    @endif
</div>