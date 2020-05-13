@extends("pages.users.userapp")
@section("usercontent")

    <div class="recent-activity clearfix">

        @if($lastPost->total() > 0)
            <ul class="items_lists res-lists" style="padding:0">
                @foreach($lastPost as $k => $item)
                    @include('pages.catpostloadpage')
                @endforeach
            </ul>
            @else
            @include('errors.emptycontent')
        @endif
    </div>
    <div class="clear"></div>
    <center>
        {!! $lastPost->render() !!}
    </center>
@endsection