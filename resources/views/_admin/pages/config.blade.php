@extends("_admin.adminapp")
        @section('header')
        <!-- colorpicker -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
        @endsection
@section("content")
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('admin.Settings') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  {{ trans('admin.dashboard') }}</a></li>
        <li class="active"> {{ trans('admin.Settings') }}</li>
    </ol>
</section>

<section class="content">
    {!!   Form::open(array('action' => 'Admin\ConfigController@setconfig', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
@if(Request::query('q') == 'others')

        <div class="row">
            <div class="col-sm-12  col-md-8 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">{{ trans('admin.OptionalConfigurations') }}</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>
                               {{ trans('admin.SitePostsUrlType') }}
                            </label>
                            {!! Form::select('siteposturl', [
                            '1' => 'yoursite.com/{category}/{slug} (Default)',
                            '2' => 'yoursite.com/{category}/{id}',
                            '3' => 'yoursite.com/{username}/{slug}',
                            '4' => 'yoursite.com/{username}/{id}',
                            '5' => 'yoursite.com/{category}/{slug}-{id}'
                             ], get_buzzy_config('siteposturl'), ['class' => 'form-control'])  !!}

                        </div>
                        <span class="help-block">{{ trans('admin.SitePostsUrlTypehelp') }}</span>

                        <hr>
                        <div class="form-group">
                            <label>
                                {{ trans('admin.Usersregistration') }}
                            </label>
                            {!! Form::select('sitevoting', [
                            '0' => trans('admin.yes'),
                            '1' => trans('admin.no')
                            ], get_buzzy_config('sitevoting'), ['class' => 'form-control'])  !!}

                        </div>
                        <span class="help-block">{{ trans('admin.Usersregistrationhelp') }}</span>
                        <hr>
                        <div class="form-group">
                                <label class="control-label">{{ trans('admin.Auto-listedonHomepage') }}</label>
                                {!! Form::select('AutoInHomepage', ['yes' => trans('admin.on'), 'no' => trans('admin.off')], get_buzzy_config('AutoInHomepage'), ['class' => 'form-control'])  !!}
                        </div>
                        <hr>
                        <div class="form-group">
                                <label class="control-label">{{ trans('admin.AutoApprovePosts') }}</label>
                                {!! Form::select('AutoApprove', ['yes' => trans('admin.on'),'no' => trans('admin.off')], get_buzzy_config('AutoApprove'), ['class' => 'form-control'])  !!}
                            <span class="help-block">{{ trans('admin.AutoApprovePostshelp') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{ trans('admin.Auto-approveeditedposts') }}</label>
                            {!! Form::select('AutoEdited', ['yes' =>trans('admin.on'),'no' => trans('admin.off')], get_buzzy_config('AutoEdited'), ['class' => 'form-control'])  !!}

                            <span class="help-block">{{ trans('admin.Auto-approveeditedpostshelp') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{ trans('admin.Auto-LoadonLists') }}</label>
                            {!! Form::select('AutoLoadLists', ['yes' => trans('admin.yes'),'no' => trans('admin.nouseload')], get_buzzy_config('AutoLoadLists'), ['class' => 'form-control'])  !!}
                            <span class="help-block">{{ trans('admin.Auto-LoadonListshelp') }}</span>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label">Reaction Vote Count </label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="showreactioniconon" value="{{  get_buzzy_config('showreactioniconon') }}">
                            </div>
                            <span class="help-block">Add number of reaction voting count to show icon on posts</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Show Preview Image on Post Page</label>
                            <div class="controls">
                                {!! Form::select('PostPreviewShow', ['no' => trans('admin.no'), 'yes' => trans('admin.yes')], get_buzzy_config('PostPreviewShow'), ['class' => 'form-control'])  !!}
                            </div>
                        </div>
                        <HR>
                        <H3>{{ trans('admin.UserPermissions') }}</H3>
                        <div class="form-group">
                            <label>
                                {{ trans('admin.Userscanpost') }}
                            </label>
                            {!! Form::select('UserCanPost', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('UserCanPost'), ['class' => 'form-control'])  !!}
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('admin.Userscandeleteownposts') }}
                            </label>
                            {!! Form::select('UserDeletePosts', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('UserDeletePosts'), ['class' => 'form-control'])  !!}
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('admin.Userscaneditownposts') }}
                            </label>
                            {!! Form::select('UserEditPosts', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('UserEditPosts'), ['class' => 'form-control'])  !!}
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('admin.Userscaneditownusernames') }}
                            </label>
                            {!! Form::select('UserEditUsername', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('UserEditUsername'), ['class' => 'form-control'])  !!}
                        </div>
                         <div class="form-group">
                            <label>
                                {{ trans('admin.Userscaneditownemails') }}
                            </label>
                             {!! Form::select('UserEditEmail', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('UserEditEmail'), ['class' => 'form-control'])  !!}
                         </div>
                        <div class="form-group">
                            <label>
                                {{ trans('admin.Userscanaddownsocialmediaaddresses') }}
                            </label>
                            {!! Form::select('UserAddSocial', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('UserAddSocial'), ['class' => 'form-control'])  !!}
                        </div>
                        <hr>
                    </div>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->

    @elseif(Request::query('q') == 'mail')

        <div class="row">
            <div class="col-sm-12  col-md-8 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        {{ trans('admin.MailSettings') }}
                        <a href="http://buzzy.akbilisim.com/admin/docs#mail" target="_blank" style="margin-top:-5px;color:#fff!important;" class="btn btn-sm btn-success pull-right"><i class="fa fa-eye"></i> See here for more info</a><br>
                     </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"> MAIL DRIVER</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" placeholder="smtp" name="MAIL_DRIVER" value="{{  env('MAIL_DRIVER') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> MAIL HOST</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" placeholder="smtp.gmail.com" name="MAIL_HOST" value="{{  env('MAIL_HOST') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> MAIL PORT</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" placeholder="587" name="MAIL_PORT" value="{{  env('MAIL_PORT') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> MAIL USERNAME</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="MAIL_USERNAME" value="{{   \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('MAIL_USERNAME')  }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> MAIL PASSWORD</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="MAIL_PASSWORD" value="{{  \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('MAIL_PASSWORD')   }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> MAIL ENCRYPTION</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" placeholder="tls" name="MAIL_ENCRYPTION" value="{{  env('MAIL_ENCRYPTION') }}">
                            </div>
                        </div>


                    </div>
                </div>

            </div><!-- /.col -->

        </div><!-- /.row -->

    @elseif(Request::query('q') == 'storage')

        <div class="row">
            <div class="col-sm-12  col-md-8 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">{{ trans('v3.file_storage_settings') }}
                        <a href="http://buzzy.akbilisim.com/admin/docs#AWSS3" target="_blank" style="margin-top:-5px;color:#fff!important;" class="btn btn-sm btn-success pull-right"><i class="fa fa-eye"></i> See here for more info</a><br>
                     </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label>{{ trans('v3.activate_s3') }}</label>
                            {!! Form::select('FILESYSTEM_DRIVER', ['local' => trans('admin.no'), 's3' => trans('admin.yes')], env('FILESYSTEM_DRIVER'), ['class' => 'form-control'])  !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label"> AWS ACCESS KEY ID</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="AWS_ACCESS_KEY_ID" value="{{ env('APP_DEMO') && \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('AWS_ACCESS_KEY_ID')  }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> AWS SECRET ACCESS KEY</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="AWS_SECRET_ACCESS_KEY" value="{{ env('APP_DEMO') && \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('AWS_SECRET_ACCESS_KEY')  }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> AWS REGION</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="AWS_DEFAULT_REGION" value="{{  env('AWS_DEFAULT_REGION') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> AWS BUCKET</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="AWS_BUCKET" value="{{  env('AWS_BUCKET')  }}">
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div><!-- /.col -->

        </div><!-- /.row -->

    @elseif(Request::query('q') == 'social')

        <div class="row">
            <div class="col-sm-12  col-md-8 col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">{{ trans('admin.SocialMedia') }}</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>  {{ trans('admin.PageUrl') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="facebookpage" value="{{  get_buzzy_config('facebookpage') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>  {{ trans('admin.PageUrl') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="twitterpage" value="{{  get_buzzy_config('twitterpage') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a> {{ trans('admin.PageUrl') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="googlepage" value="{{  get_buzzy_config('googlepage') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a> {{ trans('admin.PageUrl') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="instagrampage" value="{{  get_buzzy_config('instagrampage') }}">
                            </div>
                        </div>


                    </div>
                </div>

            </div><!-- /.col -->

        </div><!-- /.row -->

  @elseif(Request::query('q') == 'layout')
        <div class="row">
            <div class="col-sm-12  col-md-8 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">{{ trans('admin.LayoutConfiguration') }}</div>
                    <div class="panel-body">
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

                    </div>
                </div>

            </div><!-- /.col -->

        </div><!-- /.row -->
@else
    <div class="row">
        <div class="col-sm-12  col-md-8 col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">{{ trans('admin.MainConfiguration') }}</div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="control-label">{{ trans('admin.SiteLanguage') }}</label>
                        <div class="controls">
                            <select name="sitedefaultlanguage" class="form-control">
                            @if(null !== get_buzzy_config('sitename'))
                                   <option value="{{  get_buzzy_config('sitedefaultlanguage') }}" selected>{{  get_buzzy_config('sitedefaultlanguage') }}</option>
                            @endif

                            @foreach(config('languages.language') as $key => $lang)
                                <option value="{{ $key }}">{{ $key }} - {{ $lang['name'] }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                        <div class="form-group">
                            <label class="control-label">{{ trans('admin.SiteName') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="sitename" value="{{  get_buzzy_config('sitename') }}" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Site URL</label>
                            <div class="controls">
                                <input type="text" class="form-control input-lg" name="APP_URL" value="{{  url('/') }}" required="required" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="sitelogo">{{ trans('admin.SiteLogo') }}</label>
                                    <input type="file" id="sitelogo" name="sitelogo">
                                    <p class="help-block">{{ trans('admin.SiteLogohelp') }}</p>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <img class="field-image-preview img-thumbnail " width="150" src="{{ asset('assets/images/logo.png') }}">
                            </div>
                        </div>
                    <hr>
                    <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="footerlogo">{{ trans('admin.FooterSiteLogo') }}</label>
                                    <input type="file" id="footerlogo" name="footerlogo">
                                    <p class="help-block">{{ trans('admin.SiteLogohelp') }}</p>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <img class="field-image-preview img-thumbnail" src="{{ asset('assets/images/flogo.png') }}">
                            </div>

                        </div>  <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="favicon">{{ trans('admin.SiteFavicon') }}</label>
                                    <input type="file" id="favicon" name="favicon">
                                    <p class="help-block">{{ trans('admin.SiteFaviconhelp') }}</p>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <img class="field-image-preview img-thumbnail " width="40" src="{{ asset('assets/images/favicon.png') }}">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label">{{ trans('admin.SiteDefaultMetaTitle') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="sitetitle" value="{{  get_buzzy_config('sitetitle') }}" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{ trans('admin.SiteDefaultMetaDescription') }}</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="sitemetadesc" value="{{  get_buzzy_config('sitemetadesc') }}" required="required">
                            </div>
                        </div>
                <hr>
                    <div class="form-group">
                        <label class="control-label">{{ trans('admin.TermsofUsePageUrl') }}</label>
                        <div class="controls">
                            <input type="text" class="form-control input-lg" name="termspage" value="{{  get_buzzy_config('termspage') }}">
                        </div>
                        <span class="help-block">{{ trans('admin.TermsofUsePageUrlhelp') }}</span>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label">{{ trans('admin.Siteemail') }}</label>
                        <div class="controls">
                            <input type="text" class="form-control input-lg" name="siteemail" value="{{  get_buzzy_config('siteemail') }}">
                        </div>
                    </div>
                    <hr>

                    <div class="form-group">
                        <label class="control-label">{{ trans('admin.SiteLanguageCountryCodes') }}</label>
                        <div class="controls">
                            <input type="text" class="form-control input-lg" name="sitelanguage" value="{{  get_buzzy_config('sitelanguage') }}">
                        </div>
                        <span class="help-block">{!! trans('admin.SiteLanguageCountryCodeshelp') !!}</span>
                    </div>
                    <HR>
                    <div class="form-group">
                        <label>{{ trans('admin.Siteactive') }}</label>
                        {!! Form::select('Siteactive', ['yes' => trans('admin.yes'),'no' => trans('admin.no')], get_buzzy_config('Siteactive'), ['class' => 'form-control'])  !!}

                    </div>
                    <div class="form-group">
                        <label>{{ trans('admin.Siteactivenote') }}</label>
                        <input type="text" class="form-control input-lg" name="Siteactivenote" value="{{  get_buzzy_config('Siteactivenote') }}">

                    </div>

                </div>
            </div>

        </div><!-- /.col -->

    </div><!-- /.row -->
    <div class="row">

        <div class="col-sm-12  col-md-8 col-lg-6">

            <div class="panel panel-info">
                <div class="panel-heading">{{ trans('admin.LoginConfiguration') }}</div>
                <div class="panel-body form-horizontal">
                    <legend><a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a> Facebook</legend>
                    <div class="form-group">
                        <label for="facebookapp" class="col-sm-2 control-label">App ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="facebookapp" name="facebookapp" value="{{ get_buzzy_config('facebookapp') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebookappsecret" class="col-sm-2 control-label">App SECRET</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="facebookappsecret" name="facebookappsecret" value="{{  \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('facebookappsecret')  }}">
                            <input type="hidden"name="facebook_login_callback" value="{{  url('/auth/social/facebook/callback')  }}">
                        </div>
                    </div>
                    <br><br>
                    <legend><a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a> Google</legend>
                    <div class="form-group">
                        <label for="googleapp" class="col-sm-2 control-label">App ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="googleapp" name="googleapp" value="{{  get_buzzy_config('googleapp') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="googleappsecret" class="col-sm-2 control-label">App SECRET</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="googleappsecret" name="googleappsecret" value="{{  \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('googleappsecret')  }}">
                            <input type="hidden"name="google_login_callback" value="{{  url('/auth/social/google/callback')  }}">
                        </div>
                    </div>
                    <br><br>
                    <legend><a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a> Twitter</legend>
                    <div class="form-group">
                        <label for="twitterapp" class="col-sm-2 control-label">App ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="twitterapp" name="twitterapp" value="{{  get_buzzy_config('twitterapp') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="twitterappsecret" class="col-sm-2 control-label">App SECRET</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="twitterappsecret" name="twitterappsecret" value="{{  \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('twitterappsecret')  }}">
                             <input type="hidden"name="twitter_login_callback" value="{{  url('/auth/social/twitter/callback')  }}">
                        </div>
                    </div>
                    <br><br>
                    <legend><a class="btn btn-social-icon btn-vk"><i class="fa fa-vk"></i></a> Vkontakte</legend>
                    <div class="form-group">
                        <label for="VKONTAKTE_KEY" class="col-sm-2 control-label">App ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="VKONTAKTE_KEY" name="VKONTAKTE_KEY" value="{{  get_buzzy_config('VKONTAKTE_KEY') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="VKONTAKTE_SECRET" class="col-sm-2 control-label">App SECRET</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="VKONTAKTE_SECRET" name="VKONTAKTE_SECRET" value="{{  \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : get_buzzy_config('VKONTAKTE_SECRET')  }}">
                             <input type="hidden"name="vkontakte_login_callback" value="{{  url('/auth/social/vkontakte/callback')  }}">
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">

        <div class="col-sm-12 col-md-8 col-lg-6">

            <div class="panel panel-info">
                <div class="panel-heading">Use Google reCaptcha on login, register, contact form</div>
                <div class="panel-body form-horizontal">
                   
                    <div class="form-group">
                        <label for="facebookappsecret" class="col-sm-2 control-label">App ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-lg" name="reCaptchaKey" value="{{  get_buzzy_config('reCaptchaKey') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebookappsecret" class="col-sm-2 control-label">App SECRET</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-lg" name="reCaptchaSecret" value="{{ \Auth::user()->email == 'demo@admin.com' ? trans("admin.youPERMISSION") : get_buzzy_config('reCaptchaSecret')  }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebookapp" class="col-sm-2 control-label">{!! trans("v3.Usecaptchaonlogin") !!}</label>
                        <div class="col-sm-10">
                            {!! Form::select('BuzzyLoginCaptcha', ['on' => trans("admin.yes"), 'off' => trans("admin.no")], get_buzzy_config('BuzzyLoginCaptcha'), ['class' => 'form-control'])  !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebookapp" class="col-sm-2 control-label">{!! trans("v3.Usecaptchaonregister") !!}</label>
                        <div class="col-sm-10">
                            {!! Form::select('BuzzyRegisterCaptcha', ['on' => trans("admin.yes"), 'off' => trans("admin.no")], get_buzzy_config('BuzzyRegisterCaptcha'), ['class' => 'form-control'])  !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebookapp" class="col-sm-2 control-label">{!! trans("admin.Usecaptchaoncontactform") !!}</label>
                        <div class="col-sm-10">
                            {!! Form::select('BuzzyContactCaptcha', ['on' => trans("admin.yes"), 'off' => trans("admin.no")], get_buzzy_config('BuzzyContactCaptcha'), ['class' => 'form-control'])  !!}
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->

        <div class="row">

        <div class="col-sm-12  col-md-8 col-lg-6">

            <div class="panel panel-danger">
                <div class="panel-heading">{{ trans('admin.AdvancedConfiguration') }}</div>
                <div class="panel-body form-horizontal">
                    <legend>{{ trans('admin.HeadCode') }}</legend>
                    <textarea name="headcode" style="height:120px" class="form-control">{!!   rawurldecode(get_buzzy_config('headcode')) !!}</textarea>
                    <span class="help-block">{{ trans('admin.HeadCodehelp') }}</span>
                    <br>
                    <legend>{{ trans('admin.Footercode') }}</legend>
                    <textarea name="footercode" style="height:120px" class="form-control">{!!    rawurldecode(get_buzzy_config('footercode')) !!}</textarea>
                    <span class="help-block">{{ trans('admin.Footercodehelp') }}</span>

                </div>
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->

@endif
    <div class="row">
        <div class="col-sm-12  col-md-8 col-lg-6">

            <input type="submit" value="{{ trans('admin.SaveSettings') }}" class="btn btn-block btn-info btn-lg">

        </div><!-- /.col -->
    </div><!-- /.row -->
    {!! Form::close() !!}
</section>
@endsection
@section("footer")
    <!-- sweetalert -->
    <script src="{{ asset('assets/plugins/adminlte//plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/adminlte//plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            //iCheck for checkbox and radio inputs
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

        });
    </script>
@endsection