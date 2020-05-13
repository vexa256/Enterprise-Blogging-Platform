<article role="main" itemscope itemtype="https://schema.org/NewsArticle" class="news__item clearfix" data-type="{{ $post->type }}" data-id="{{ $post->id }}" data-url="{{ generate_post_url($post) }}" data-title="{{ $post->title }}" data-description="{{ $post->body }}" data-keywords="" data-share="0">
    <meta itemprop="mainEntityOfPage" content="{{ generate_post_url($post) }}">
    <meta itemprop="dateModified" content="{{ $post->created_at->toW3cString() }}"/>
    <meta itemprop="inLanguage" content="{{ get_buzzy_config('sitelanguage') }}" />
    <meta itemprop="genre" content="news" name="medium" />

    <div class="content-body clearfix">
        <div class="content-body--left">
            <div class="content-sticky clearfix">
                @include("_particles.post_share_icons")
            </div>
        </div>
        <div class="content-body--right">
            @if($post->approve == 'draft')
                <div class="label label-staff" >{{ trans('updates.thisdraftpost') }}</div>
            @endif
            <div class="content-title">
                <h1 itemprop="headline"><a href="{{ generate_post_url($post) }}">{{ $post->title }}</a></h1>
            </div>

            @include("_particles.post_action_buttons")

            @include("_particles.post_featured_image")

            <div class="content-info">
                 @include("_particles.post_author" , ["show_categories" => true, "show_views" => true])
            </div>
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

    </div> 
    <div class="clear"></div>
</article>
