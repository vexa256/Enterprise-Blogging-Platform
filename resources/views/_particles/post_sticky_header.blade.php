@if(get_buzzy_config('PostPageAutoload') != 'related')
<div class="content-header hide-mobile">
    <div class="content-header__container container">
        <div class="content-header__container__left">
            <div class="content-header__container__left__home">
                <a href="/"><i class="material-icons">&#xE88A;</i></a>
            </div>
            <div class="content-header__container__left__title">{{ $post->title }}</div>
        </div>
        <div class="content-header__container__right">


        </div>
    </div>
    <div class="content-header__progress--container">
        <div class="content-header__progress--container__progress"></div>
    </div>
</div>
@endif