
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{!! trans("admin.BuzzyQuizzesPluginSettings")  !!}</h4>
</div>

<div class="modal-body">

    <div class="form-group">
        <label class="control-label">{!! trans("admin.QuizzesPluginResultType")  !!}</label>
        {!! Form::select('BuzzyQuizzesPopup', ['on' => trans("admin.BuzzyQuizzesSpecialResultPopup"), 'off' => trans("admin.OnlyBuzzFeedStyleResult")], get_buzzy_config('BuzzyQuizzesPopup'), ['class' => 'form-control'])  !!}
        <p>{!! trans("admin.QuizzesPluginResultTypeDesc")  !!}</p>
    </div>

</div>