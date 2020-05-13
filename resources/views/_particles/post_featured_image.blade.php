@if(get_buzzy_config('PostPreviewShow')=='yes')
    <figure class="content-body__image" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
        <img class=" lazyload" data-src="{{ makepreview($post->thumb, 'b', 'posts') }}" alt="{{ $post->title }}" width="788" style="display: block;">
        <meta itemprop="url" content="{{ makepreview($post->thumb, 'b', 'posts') }}">
        <meta itemprop="width" content="788">
        <meta itemprop="height" content="443">
    </figure>
@endif