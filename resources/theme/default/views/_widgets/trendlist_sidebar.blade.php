@if($lastTrending)
    <ul class="items_lists">
        @foreach($lastTrending as $item)
            @include('._particles._lists.items_list', ['listtype' => 'big_image titm bolb', 'featuredon' => 'on', 'descof' => 'off','linkcolor' => 'blue'])
        @endforeach
    </ul>
@endif