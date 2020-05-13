
<style type="text/css">
body {font-family: {!!  get_buzzy_config('T_1_sitefontfamily', get_buzzy_config('sitefontfamily')) !!};}
@if(get_buzzy_config('T_1_BodyBC'))
  body { background: {{ get_buzzy_config('T_1_BodyBC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarBC'))
  .header { background: {{ get_buzzy_config('T_1_NavbarBC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarTBLC'))
    .header__appbar { border-top: 3px solid {{ get_buzzy_config('T_1_NavbarTBLC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarLC'))
    .header__appbar--left__menu__list__item > a{ color: {{ get_buzzy_config('T_1_NavbarLC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarLC'))
    .header__appbar--left__menu__list__item > a > i{ color: {{ get_buzzy_config('T_1_NavbarLC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarLHC'))
    .header__appbar--left__menu__list__item > a:hover{color: {{ get_buzzy_config('T_1_NavbarLHC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarLHC'))
    .header__appbar--left__menu__list__item > a:hover > i{color: {{ get_buzzy_config('T_1_NavbarLHC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarCBBC'))
    .button.button-create {
        background: {{ get_buzzy_config('T_1_NavbarCBBC') }}!important;
        color: {{ get_buzzy_config('T_1_NavbarCBFC') }}!important;
        border-color: {{ get_buzzy_config('T_1_NavbarCBBC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarCBFC'))
    .button.button-create i {color: {{ get_buzzy_config('T_1_NavbarCBFC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarCBHBC'))
    .button.button-create:hover {background: {{ get_buzzy_config('T_1_NavbarCBHBC') }}!important;color: {{ get_buzzy_config('T_1_NavbarCBHFC') }}!important;}
@endif
@if(get_buzzy_config('T_1_NavbarCBHFC'))
    .button.button-create:hover i {color: {{ get_buzzy_config('T_1_NavbarCBHFC') }}!important;}
@endif
</style>