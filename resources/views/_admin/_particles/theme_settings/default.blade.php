<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">{{ trans('admin.MainConfiguration') }}</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.GoogleFontConfig') }}</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="googlefont" value="{{  get_buzzy_config('googlefont') }}">
                    </div>
                    <span class="help-block">{!!   trans('admin.GoogleFontConfighelp') !!} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.SiteFont') }} </label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="sitefontfamily" value="{{  get_buzzy_config('sitefontfamily') }}">
                    </div>
                    <span class="help-block">{{ trans('admin.SiteFonthelp') }} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.SiteLayoutType') }}</label>
                    {!! Form::select('LayoutType', ['mode-wide' => trans('admin.Wide'),'mode-boxed' => trans('admin.Boxed')], get_buzzy_config('LayoutType'), ['class' => 'form-control'])  !!}

                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarType') }}</label>
                    {!! Form::select('NavbarType', ['navbar-fixed' => trans('admin.Fixed'),'mode-relative' => trans('admin.Relative')], get_buzzy_config('NavbarType'), ['class' => 'form-control'])  !!}

                </div>

                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.SiteBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="BodyBC" class="form-control" value="{{  get_buzzy_config('BodyBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('BodyBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.SiteBackgroundColorOnBoxedMode') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="BodyBCBM" class="form-control" value="{{  get_buzzy_config('BodyBCBM') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('BodyBCBM') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarBC" class="form-control" value="{{  get_buzzy_config('NavbarBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarTop3PixelBorderLineColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarTBLC" class="form-control" value="{{  get_buzzy_config('NavbarTBLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarTBLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarLC" class="form-control" value="{{  get_buzzy_config('NavbarLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkHoverColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarLHC" class="form-control" value="{{  get_buzzy_config('NavbarLHC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarLHC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonBackgroundColor') !!}<</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarCBBC" class="form-control" value="{{  get_buzzy_config('NavbarCBBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarCBFC" class="form-control" value="{{  get_buzzy_config('NavbarCBFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverBackgroundColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarCBHBC" class="form-control" value="{{  get_buzzy_config('NavbarCBHBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBHBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="NavbarCBHFC" class="form-control" value="{{  get_buzzy_config('NavbarCBHFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBHFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>

                <hr>
                <div class="form-group">
                    <H3>
                        {{ trans('admin.UseRight-to-LeftLanguageSupport') }}
                    </H3>
                    {!! Form::select('languagetype', ['rtl' => trans('admin.yes'), '' => trans('admin.no')], get_buzzy_config('languagetype'), ['class' => 'form-control'])  !!}

                </div>
            </div>
        </div>

    </div><!-- /.col -->

</div><!-- /.row -->