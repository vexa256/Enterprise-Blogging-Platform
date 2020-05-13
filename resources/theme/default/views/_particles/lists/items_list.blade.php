@if(isset($item))
    <li class="item {{ $listtype }}">
        @if(!isset($setbadgeof))
        @if( $item->type=='quiz')
            <div class="badge quiz"><div class="badge-img"></div></div>
            @elseif(isset($featuredon) ? true : false and $item->featured_at !== null)
            <div class="badge featured"><div class="badge-img"></div></div>
        @endif
        @endif
            <div class="item-cover">

                <a class="item_link" href="{{ generate_post_url($item) }}">

                    <div class="item_media"  @if(isset($setmediamarginbottom))style="margin-bottom: {{ $setmediamarginbottom }};" @endif>
                        @if( $item->type=='video')<span class="icon-video fa fa-play"></span> @endif
                        <img src="{{ makepreview($item->thumb, 's', 'posts') }}" class="item__image" alt="{{ $item->title }}" width="185" height="110">
                    </div>
                </a>
                <div class="item_body" @if(isset($itembodyheight)) style="height: {{ $itembodyheight }};" @endif>
                    <h2 class="item_title">
                        <a class="item_link {{ $linkcolor }}" href="{{ generate_post_url($item) }}">
                            {!! $item->title  !!}
                        </a>
                    </h2>

                    @if($descof=='on')
                        <p class="item_desc">{{ str_limit($item->body, 90) }}</p>
                    @endif
                    @unless(isset($metaof))
                        <div class="item_meta">

                            <div class="item_meta__item">
                                 @if($item->user)
                                <a href="{{ action('UsersController@index', [$item->user->username_slug ]) }}"><i class="fa fa-user"></i> {{ $item->user->username }}</a>
                                @endif
                            </div>
                            <div class="item_meta__item timestamp">
                                <i class="fa fa-clock-o"></i>
                                <span class="timestamp_timeago">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="item_meta__item">
                                <i class="fa fa-share-alt"></i> {{ isset($item->shared->facebook) ? $item->shared->facebook : 0 }}
                            </div>
                            <div class="item_meta__item">
                                <i class="fa fa-eye"></i> {{ isset($item->popularityStats->all_time_stats) ? number_format($item->popularityStats->all_time_stats) : "0" }}
                            </div>
                            @if($descof=='on')
                                <div class="item_meta__item pull-r" style="margin-right: 0; ">
                                    <div class="item_meta__item pull-r" style="margin-right: 0; ">
                                        <a href="https://www.facebook.com/share.php?u={{ generate_post_url($item) }}" data-id="{{ $item->id }}" class="share_social is-facebook  popup-action"><i class="fa fa-facebook"></i></a>
                                        <a href="https://twitter.com/share?url={{ generate_post_url($item) }}&amp;text={{ $item->title  }}" data-id="{{ $item->id }}" class="share_social is-twitter popup-action"><i class="fa fa-twitter"></i></a>
                                    </div>

                                </div>
                            @endif
                        </div>
                    @endunless

                </div>
            </div>
</li>
@endif