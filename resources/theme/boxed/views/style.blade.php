
    <style type="text/css">
        body {
            font-family: {!!    get_buzzy_config('T_1_sitefontfamily', get_buzzy_config('sitefontfamily')) !!};
            background: {{  get_buzzy_config('T_1_BodyBC') }}!important;
        }
        .header {
            background: {{ get_buzzy_config('T_1_NavbarBC') }}!important;
        }
        .header__appbar_top_color {
            border-top: 3px solid {{ get_buzzy_config('T_1_NavbarTBLC') }}!important;
        }
        .header__appbar_menu {
            background: {{ get_buzzy_config('T_1_NavbarMenuBC') }}!important;
        }
        .header__appbar--left__nav{
            color: {{ get_buzzy_config('T_1_NavbarMenuToogleC') }}!important;
        }
        .header__appbar--left__menu__list__item > a{
            color: {{ get_buzzy_config('T_1_NavbarLC') }}!important;
        }
        .header__appbar--left__menu__list__item > a > i{
            color: {{ get_buzzy_config('T_1_NavbarLC') }}!important;
        }
        .header__appbar--left__menu__list__item > a:hover{
            color: {{ get_buzzy_config('T_1_NavbarLHC') }}!important;
        }
        .header__appbar--left__menu__list__item > a:hover > i{
            color: {{ get_buzzy_config('T_1_NavbarLHC') }}!important;
        }
        .button.button-create {
            background: {{ get_buzzy_config('T_1_NavbarCBBC') }}!important;
            color: {{ get_buzzy_config('T_1_NavbarCBFC') }}!important;
            border-color: {{ get_buzzy_config('T_1_NavbarCBBC') }}!important;
        }
        .button.button-create i {
            color: {{ get_buzzy_config('T_1_NavbarCBFC') }}!important;
        }
        .button.button-create:hover {
            background: {{ get_buzzy_config('T_1_NavbarCBHBC') }}!important;
            color: {{ get_buzzy_config('T_1_NavbarCBHFC') }}!important;
        }
        .button.button-create:hover i {
            color: {{ get_buzzy_config('T_1_NavbarCBHFC') }}!important;
        }
    </style>