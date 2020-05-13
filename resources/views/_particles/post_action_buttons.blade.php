@can('update', $post)
    <div style="margin:5px 0">
      
    @if($post->approve == 'no')
        @can('approve', $post)
            <a href="{{ action('Admin\PostsController@approvePost', $post->id) }}" class="button button-orange button-small" style="height:26px"><i class="material-icons" style="font-size: 18px;margin-top:-2px;vertical-align: middle">&#xE90A;</i> {{ trans('index.approve') }}</a>
        @else
        <a href="#" class="button button-orange button-small" style="cursor: default;height:26px"><i class="material-icons"  style="font-size: 18px;margin-top:-2px;vertical-align: middle">&#xE422;</i> {{ trans('index.waitapprove') }}</a>
        @endcan
    @endif

    @can('update', $post)
        <a href="{{ action('PostEditorController@showPostEdit', [$post->id]) }}" class="button button-green button-small" style="height:26px"><i class="material-icons " style="font-size: 18px;margin-top:-2px;vertical-align: middle">&#xE150;</i>  {{ trans('index.edit') }}</a>
    @endcan
    @can('delete', $post)
        <a href="{{ action('PostEditorController@deletePost', [$post->id]) }}" onclick="confim()" class="button button-red button-small " style="height:26px"><i class="material-icons" style="font-size: 18px;margin-top:-2px;vertical-align: middle">&#xE16C;</i></a>
    @endcan

    @if($publish_from_now)
        <div class="label label-admin" style="margin-left:5px">{{ trans('v3.scheduled_date', ['date' => $post->published_at->format('j M Y, h:i A')]) }}</div>
    @endif
    </div>
@endcan