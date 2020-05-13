<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{!! trans("admin.DisqusPluginSettings")  !!}</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="control-label">{!! trans("admin.DisqusCode")  !!}</label>
        <input type="text" class="form-control input-lg" name="DisqussCommentcode" value="{{  get_buzzy_config('DisqussCommentcode') }}">

    </div>
</div>