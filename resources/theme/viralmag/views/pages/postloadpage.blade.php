<article role="main" itemscope itemtype="https://schema.org/NewsArticle" class="news__item" data-type="{{ $post->type }}" data-id="{{ $post->id }}" data-url="{{ generate_post_url($post) }}" data-title="{{ $post->title }}" data-description="{{ $post->body }}" data-keywords="" data-share="0">
    <meta itemprop="mainEntityOfPage" content="{{ generate_post_url($post) }}">
    <meta itemprop="dateModified" content="{{ $post->created_at->toW3cString() }}"/>
    <meta itemprop="inLanguage" content="{{ get_buzzy_config('sitelanguage') }}" />
    <meta itemprop="genre" content="news" name="medium" />

    <div class="content-body">
        <div class="content-body--left">
            <div class="content-sticky">
                @include("_particles.post_share_icons")
            </div>
        </div>
        <div class="content-body--right">
            @if($post->approve == 'draft')
                <div class="label label-staff" >{{ trans('updates.thisdraftpost') }}</div>
            @endif
            <div class="content-title">
                <div class="badges">

                    <div class="item_category">
                        @php($postatpe=\App\Categories::byType($post->type)->first())
                        @php($postacatpe=getfirstcat($post->categories))
                        {!! isset($post->categories)  && isset($postacatpe) ? '<a href="'. action('PagesController@showCategory', ['id' => $postacatpe->name_slug ]).'" class="seca"> '.$postacatpe->name. '</a>' : '' !!} {!! isset($postatpe) ? '<a href="'.action('PagesController@showCategory', ['id' => $postatpe->name_slug ]) .'" style="margin-right:5px"> '.$postatpe->name. '</a>' : '' !!}
                    </div>

                    @if( $post->type=='quiz')
                        <div class="badge quiz"><div class="badge-img"></div></div>
                    @elseif($post->featured_at !== null)
                        <div class="badge featured"><div class="badge-img"></div></div>
                    @endif
                    {{  get_reaction_icon($post) }}
                </div>

                <h1 itemprop="headline"><a href="{{ generate_post_url($post) }}">{{ $post->title }}</a></h1>
            </div>

            @include("_particles.post_action_buttons")
          
            
            <div class="content-info">
               @include("_particles.post_author", ['show_views' => true])
            </div>
        
             @include("_particles.post_featured_image")

             @include('_particles.ads', ['position' => 'PostShareBw', 'width' => '788', 'height' => 'auto'])

            <div class="content-body__description" itemprop="description">{!! nl2br($post->body) !!}</div>

            <div class="content-body__detail" itemprop="articleBody">

                @include("_particles.lists.entryslists")

            </div>

            <!-- tags -->
            @if ($post->tags != "")
            <div class="content-tag hide-mobiles">
                @foreach(explode(',', $post->tags) as $tag)
                <span class="tagy"><a href="{{ action('PagesController@showtag', $tag) }}">{{$tag}}</a></span>
                @endforeach
            </div>
            @endif

             @include('_particles.ads', ['position' => 'PostBelow', 'width' => '788', 'height' => 'auto'])

            @include("_forms._reactionforms")

             @include("_particles.post_related_posts")

            @if(isset($commentson))
             @include("_particles.comments")
            @endif

        </div>

    </div> <div class="clear"></div>
</article>
