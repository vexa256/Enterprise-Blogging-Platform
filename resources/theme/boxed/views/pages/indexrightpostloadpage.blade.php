@foreach($lastNews as $key => $item)
    <div class="content-timeline__item content-viral__item is-active" style="  margin-bottom: 15px;">

        <article class="headline__blocks  headline__blocks--small " style="width: 100%;margin-top: 0">
            <div class="badges">
                @if( $item->type=='quiz')
                    <div class="badge quiz"><div class="badge-img"></div></div>
                @elseif($item->featured_at !== null)
                    <div class="badge featured"><div class="badge-img"></div></div>
                @endif
                {{  get_reaction_icon($item) }}
            </div>

            <div class="headline__blocks__image" style="background-image: url({{ makepreview($item->thumb, 'b', 'posts') }})"></div>
            <a class="headline__blocks__link" href="{{ generate_post_url($item) }}" title="{{ $item->title }}" ></a>
            <header class="headline__blocks__header">
                <h2 class="headline__blocks__header__title  headline__blocks__header__title--small">{{ $item->title }}</h2>
                <ul class="headline__blocks__header__other">
                    <li class="headline__blocks__header__other__author">{{ $item->user ? $item->user ? $item->user->username : '' : '' }}</li>
                    <li class="headline__blocks__header__other__date"><i class="material-icons"></i> <time datetime="{{ $item->created_at->toW3cString() }}">{{ $item->created_at->diffForHumans() }}</time></li>
                </ul>
            </header>
        </article>


    </div>
    @if($key ==0 )
            @include('_particles.ads', ['position' => 'Homencolsec', 'width' => 'auto', 'height' => 'auto'])
    @endif
@endforeach

