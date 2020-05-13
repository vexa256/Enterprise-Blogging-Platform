<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">{{ trans('admin.MainConfiguration') }}</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.GoogleFontConfig') }}</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="T_1_googlefont" value="{{  get_buzzy_config('T_1_googlefont', get_buzzy_config('googlefont')) }}">
                    </div>
                    <span class="help-block">{!!   trans('admin.GoogleFontConfighelp') !!} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.SiteFont') }} </label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="T_1_sitefontfamily" value="{{  get_buzzy_config('T_1_sitefontfamily', get_buzzy_config('sitefontfamily')) }}">
                    </div>
                    <span class="help-block">{{ trans('admin.SiteFonthelp') }} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">Homepage Headline Style</label>
                    <div class="controls">
                        {!! Form::select('T_1_SiteHeadlineStyle', ['1' => 'Style 1 - Boxes', '3' => 'Style 2 - Boxes', '4' => 'Style 3 - Tall Boxes', '5' => 'Style 4 - Two Big Boxes', '2' => 'Style 5 - Slider Type', 'off' => 'No Headline Post'], get_buzzy_config('T_1_SiteHeadlineStyle'), ['class' => 'form-control'])  !!}

                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">Category Pages Headline Style</label>
                    <div class="controls">
                        {!! Form::select('T_1_CatHeadlineStyle', ['1' => 'Style 1 - Boxes', '3' => 'Style 2 - Boxes', '4' => 'Style 3 - Tall Boxes', '5' => 'Style 4 - Two Big Boxes', '2' => 'Style 5 - Slider Type', 'off' => 'No Headline Post'], get_buzzy_config('T_1_CatHeadlineStyle'), ['class' => 'form-control'])  !!}

                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">Post Page AutoLoad Style</label>
                    <div class="controls">
                        {!! Form::select('PostPageAutoload', ['autoload' => 'Autoload Next Post', 'related' => 'Show only "You may also like" section'], get_buzzy_config('PostPageAutoload'), ['class' => 'form-control'])  !!}

                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.SiteBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_BodyBC" class="form-control" value="{{  get_buzzy_config('T_1_BodyBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('T_1_BodyBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>

                <div class="form-group">
                    <label>{{ trans('admin.NavbarBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarBC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>
                <div class="form-group">
                    <label>Menu {{ trans('admin.NavbarBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarMenuBC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarMenuBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('T_1_NavbarMenuBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                    <div class="form-group">
                    <label>Menu Mobile Toogle Icon Color</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarMenuToogleC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarMenuToogleC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('T_1_NavbarMenuToogleC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarTop3PixelBorderLineColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarTBLC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarTBLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarTBLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarLC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkHoverColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarLHC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarLHC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarLHC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonBackgroundColor') !!}<</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarCBBC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarCBBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarCBFC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarCBFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverBackgroundColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarCBHBC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarCBHBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBHBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="T_1_NavbarCBHFC" class="form-control" value="{{  get_buzzy_config('T_1_NavbarCBHFC') }}">
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