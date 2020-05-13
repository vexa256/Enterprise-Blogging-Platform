 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-remove"></i></button>
        <h4 class="modal-title">{!! trans("admin.easyCommentPluginSettings") !!}</h4>
    </div>
    <div class="modal-body">

        <div class="form-group">
            <label class="control-label">{{ trans("admin.easyCommentTheme") }}</label>
            {!! Form::select('easyCommentTheme', ['Default' => 'Default','Dark' => 'Dark','Boxed' => 'Boxed','Envato' => 'Envato', 'Blog' => 'Blog'], get_buzzy_config('easyCommentTheme'), ['class' => 'form-control'])  !!}
            <p>{!! trans("admin.easyCommentThemeDesc")  !!}</p>
        </div>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.easyCommentTitle")  !!}</label>
            <input type="text" class="form-control input-lg" name="easyCommentTitle" value="{{  get_buzzy_config('easyCommentTitle') }}">
            <p>{!! trans("admin.easyCommentTitleDesc")  !!}</p>
        </div>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.easyCommentInitiationUrl")  !!}</label>
            <input type="text" class="form-control input-lg" name="easyCommentcode" value="{{  get_buzzy_config('easyCommentcode', url('/comments'). '/') }}">
        <p>You should install your script via <b>{{ url('/comments/app/install.php') }}</b> then add this url as <b>{{ url('/comments'). '/' }}</b></p>
        </div>
    </div>