@extends("app")

@section('head_title', $page->title .' | '.get_buzzy_config('sitename') )

@section("content")

<div class="content">
<div class="container">
    <div class="mainside" style="min-height: 900px">
    <br><br>
    <h1 style="margin-bottom:10px">{{ $page->title }}</h1>
        {!! $page->text  !!}
    </div>
    <div class="sidebar">

        @include("_widgets.facebooklike")

    </div>
</div>
</div>


@endsection