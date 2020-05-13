<div class="box box-widget widget-user" style="margin-bottom: 30px">

    <div class="overlay hide">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header  bg-default" style=" height: 140px;background: #FBFBFB;padding: 20px 120px 20px 20px;">
        <h3 class="widget-user-username" style="font-weight: 500;text-shadow: none">{{ $name }}</h3>
        <h5 class="widget-user-desc" style="line-height:16px;font-weight: 500;color:#777">{!! $desc  !!} </h5>
        <div class="info">
            {!!  $weblink == null ? '' : '<a href="'.$weblink.'" target="_blank" style="margin-right:10px"><i class="fa fa-globe" style="margin-right:5px"></i> Web site</a>'  !!}
            {!!  $docslink == null ? '' : '<a href="'.$docslink.'" target="_blank"><i class="fa fa-book" style="margin-right:5px"></i> '.trans("admin.Docs").'</a>'  !!}
            @if($price!='soon' && !empty($current_version))<span  style="color: #ccc;margin:0">v.{{ $current_version }}</span>@endif
        
        </div>
    </div>
    <div class="widget-user-image" style=" top: 15px;left:auto;right: 15px; margin-left:0;">
        <img class="img-circle" src="{{ $icon }}" alt="{{ $name }}">
    </div>
 
    <div class="box-footer" style="height: 60px;max-height: 60px; padding: 15px 10px 10px 15px;">
        <div class="row">
            <div class="col-sm-8 item-actions" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-item-type="plugin">
                @unless($price=='soon')
                    @if($activation_requied)
                        <a href="javascript:;" data-item-id="{{ $item_id }}" data-item-name="{{ $name }}" data-item-buy="{{ $buylink }}" data-item-img="{{ $icon }}" class="btn btn-warning btn-sm  pull-left register-item" style="text-align: left;width:auto"><i class="fa fa-unlock" style="margin-right:10px"></i> {{ trans('admin.ActivateCode') }}</a>
                         @if($buylink != null)
                            <a href="{{ $buylink }}" class="btn btn-success pull-left btn-sm"style="margin-left:10px" target="_blank"><i class="fa fa-cart-plus" style="margin-right:10px"></i> {{ trans("admin.BuyNow") }}</a>
                        @endif
                    @elseif(!$instaled)
                        <button type="button" class="btn btn-info btn-sm pull-left download-item" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}"><i class="fa fa-check" style="margin-right:10px"></i> {{ trans('admin.download') }}</button>
                    @elseif($update_required)
                        <button type="button" class="btn btn-success btn-sm pull-left download-item" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}"><i class="fa fa-download" style="margin-right:10px"></i> {{ trans('admin.download') }} v.{{$version}}</button>
                    @elseif($active)
                        <button type="button" class="btn btn-default btn-sm  pull-left activate-item acthover"><span class="current show"><i class="fa fa-check" style="margin-right:10px"></i> {{ trans('admin.Activated') }}</span><span class="hover hide"><i class="fa fa-remove" style="margin-right:10px"></i>  {{ trans('admin.Deactivate') }}</span></button>
                        @if($settingon)
                            <button type="button" class="btn btn-warning btn-sm " data-toggle="modal" data-target="#modal{{$code}}" style="float:left;width:auto;text-align: left;margin-left:10px"><i class="fa fa-cog" style="margin-left:0"></i> </button>
                        @endif
                    @else
                        <button type="button" class="btn btn-info btn-sm pull-left activate-item" style="text-align: left"><i class="fa fa-download" style="margin-right:10px"></i> {{ trans('admin.Install') }}</button>
                    @endif
                @endunless
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-sm-4" style="padding-right: 30px">
                @if($price=='soon')
                    <span class="badge bg-white pull-right">{!! trans("admin.Notavailabeyet") !!}</span>
                @elseif($price=='FREE')
                    <span class="badge bg-white pull-right" style="font-weight:400;color: #969696;background-color: #F0F0F0;">{!! trans("admin.FREE") !!}</span>
                @else
                    <span class="badge bg-green pull-right">{{ $price }}</span>
                @endif
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <style> .acthover:hover .current{display:none!important} .acthover:hover .hover{display:block!important}</style>
   @if($settingon)
        <div class="modal modal-info" id="modal{{$code}}" @if($code == "translationmanager")style="width:100%; overflow:hidden;height:100%" @endif>
            <div class="modal-dialog" @if($code == "homepagebuilder")style="width:80%" @elseif($code == "translationmanager")style="width:98%; height:100%" @endif>
                <div class="modal-content" @if($code == "translationmanager")style="width:100%; height:95%" @endif>
                    {!!   Form::open(array('action' => 'Admin\ConfigController@setconfig', 'method' => 'POST','style' => 'height:100%;', 'enctype' => 'multipart/form-data')) !!}
                    @include('_admin._particles.plugin_settings.'. $code)
                    <div class="clearfix"></div>
                    @unless($code == "translationmanager")
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{!! trans("admin.close")  !!}</button>
                        <input type="submit" value="{!! trans("admin.SaveSettings")  !!}" class="btn btn-info btn-outline">
                    </div>
                    @endunless
                    {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

   @endif
</div>
