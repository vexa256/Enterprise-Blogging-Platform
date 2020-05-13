@extends("pages.users.userapp")
@section("usercontent")
<h2> {{ trans('updates.followingposts') }}</h2>

    <div class="recent-activity">
        <br><br>
        @if($lastPost->total() > 0)

        <ul class="items_lists res-lists">

            @foreach($lastPost as $item)
                @include('._particles._lists.items_list', ['listtype' => 'bolb titb','descof' => 'on','linkcolor' => 'default'])
            @endforeach
        </ul>
        <div class="clear"></div>
            {!! $lastPost->render() !!}
        @else
            @include('errors.emptycontent')
        @endif

    </div>

@endsection