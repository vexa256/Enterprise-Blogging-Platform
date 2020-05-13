@extends("pages.users.userapp")
@section("usercontent")

    <div class="recent-activity">

        @if($lastPost->total() > 0)
            <ul class="items_lists res-lists" style="padding:0">

                @foreach($lastPost as $item)
                    @include('pages.catpostloadpage')
                @endforeach
            </ul>
            @else
            @include('errors.emptycontent')
        @endif
    </div>
    <center>
        {!! $lastPost->render() !!}
    </center>
@endsection