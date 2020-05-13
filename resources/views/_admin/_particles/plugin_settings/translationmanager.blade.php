
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{!! trans("admin.BuzzyTranslationManager")  !!}</h4>
</div>

<div class="modal-body" style="width:100%; height:100%;padding: 0">
<iframe src="{{ url(config('translation-manager.route.prefix')) }}" width="100%" height="100%"></iframe>


</div>