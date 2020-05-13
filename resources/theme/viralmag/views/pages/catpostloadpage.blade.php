<div class="content-timeline__item content-viral__item columns2 is-active">
    <article class="headline__blocks headline__blocks--large ">
        <div class="badges">
            @if( $item->type=='quiz')
                <div class="badge quiz"><div class="badge-img"></div></div>
            @elseif( $item->type=='poll')
                <div class="badge poll"><div class="badge-img"></div></div>
            @elseif($item->featured_at !== null)
                <div class="badge featured"><div class="badge-img"></div></div>
            @endif
            {{  get_reaction_icon($item) }}
        </div>

        <div class="headline__blocks__image" style="background-image: url({{ makepreview($item->thumb, 'b', 'posts') }})"></div>
        <a class="headline__blocks__link" href="{{ generate_post_url($item) }}" title="{{ $item->title }}" ></a>
        <header class="headline__blocks__header">
            <h2 class="headline__blocks__header__title headline__blocks__header__title--large">{{ str_limit($item->title, 55) }}</h2>
            <p class="headline__blocks__header__desc">{{ str_limit($item->body, 75) }}</p>
            <ul class="headline__blocks__header__other">
                <li class="headline__blocks__header__other__author">{{ $item->user ? $item->user->username : '' }}</li>
                <li class="headline__blocks__header__other__date"><i class="material-icons"></i> <time datetime="{{ $item->created_at->toW3cString() }}">{{ $item->created_at->diffForHumans() }}</time></li>
            </ul>
        </header>
    </article>
</div>
