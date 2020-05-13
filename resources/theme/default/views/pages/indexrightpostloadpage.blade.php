@if($lastNews)
    <ul class="items_lists">
        @foreach($lastNews as $key => $item)
            @include('._particles._lists.items_list', ['listtype' => 'big_image small-h bolb titm','featuredon' => 'on', 'descof' => 'off','linkcolor' => 'default'])

            @if($key ==0 )
                @foreach(\App\Widgets::where('type', 'Homencolsec')->where('display', 'on')->get() as $widget)
                    {!! $widget->text !!}
                @endforeach
            @endif

        @endforeach
    </ul>

@endif