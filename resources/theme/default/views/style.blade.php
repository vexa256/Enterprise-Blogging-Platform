<style type="text/css">
    body {
        font-family: {!!    get_buzzy_config('sitefontfamily') !!};
        background: {{  get_buzzy_config('BodyBC') }}!important;}
    body.mode-boxed {
        background: {{  get_buzzy_config('BodyBCBM') }}!important; }
    header {
        background: {{ get_buzzy_config('NavbarBC') }}!important;
        border-top: 3px solid {{ get_buzzy_config('NavbarTBLC') }}!important;}
    .header  a{
        color: {{ get_buzzy_config('NavbarLC') }}!important;}
    .header a > i{
        color: {{ get_buzzy_config('NavbarLC') }}!important;}
    .header a:hover{
        color: {{ get_buzzy_config('NavbarLHC') }}!important;}
    .header a:hover > i{
        color: {{ get_buzzy_config('NavbarLHC') }}!important;}
    .header .create-links > a {
        background: {{ get_buzzy_config('NavbarCBBC') }}!important;
        color: {{ get_buzzy_config('NavbarCBFC') }}!important;
        border-color: {{ get_buzzy_config('NavbarCBBC') }}!important;}
    .header .create-links > a i {
        color: {{ get_buzzy_config('NavbarCBFC') }}!important;}
    .header .create-links > a:hover {
        background: {{ get_buzzy_config('NavbarCBHBC') }}!important;
        color: {{ get_buzzy_config('NavbarCBHFC') }}!important;}
    .header .create-links > a:hover i {
        color: {{ get_buzzy_config('NavbarCBHFC') }}!important;}
    .list-count:before {
        background: {{ get_buzzy_config('NavbarTBLC') }}!important;}
</style>