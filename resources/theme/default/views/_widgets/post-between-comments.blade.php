
<div class="row">
    <div class="{{ $post->pagination==null ? '' : '' }}" data-auto="{!!  get_buzzy_config('AutoLoadLists') ?: 'no' !!}">
        <ul class="items_lists square">
            @foreach($lastFeatures as $item)
                @include('._particles._lists.items_list', ['listtype' => 'big_image titm bolb','descof' => 'off', 'setbadgeof' => 'off', 'itembodyheight' => '50px', 'metaof' => 'off', 'linkcolor' => 'default'])
            @endforeach

        </ul>
    </div>
</div>
