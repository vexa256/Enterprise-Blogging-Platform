@extends("pages.users.userapp")
@section("usercontent")
    <div class="recent-activity">

        @if($lastPost->total() > 0)
            <ul class="items_lists res-lists">

                @foreach($lastPost as $item)
                    @include('._particles._lists.items_list', ['listtype' => 'bolb titb','descof' => 'on','linkcolor' => 'default'])
                @endforeach
            </ul>
            @else
            @include('errors.emptycontent')
        @endif
    </div>

    {!! $lastPost->render() !!}
@endsection