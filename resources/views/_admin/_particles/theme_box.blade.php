<div class="box box-widget widget-user" style="margin-bottom: 30px">
    <div class="overlay hide">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header  bg-default" style=" height: auto;background: #FBFBFB;padding: 10px;">
        @if($price!='soon' && !empty($current_version))<span class="pull-right badge bg-red" style="float:none;position:absolute;right:20px;top:20px;  box-shadow: 0 2px 3px rgba(0,0,0,.5);margin:0">v.{{ $current_version }}</span>@endif
        <img style="width:100%;height:auto" src="{{ $icon }}" alt="{{ $name }}">
    </div>

    <div class="box-footer" style="height: 60px;max-height: 60px; padding: 15px 10px 10px 15px;">
        <div class="row">
            <div class="col-sm-8 border-right">
                <h3 class="widget-user-username" style="font-weight: 500;text-shadow: none">
                    {{ $name }}

                    @if($price=='soon')
                        <span class="badge bg-white" style="margin-left: 10px">{!! trans("admin.Notavailabeyet") !!}</span>
                    @elseif($price=='FREE')
                        <span class="badge bg-white" style="margin-left: 10px;font-weight:400;color: #969696;background-color: #F0F0F0;">{!! trans("admin.FREE") !!}</span>
                    @else
                        <span class="badge bg-green" style="margin-left: 10px">{{ $price }}</span>
                    @endif

                </h3>
                <div class="info">
                    {!!  $weblink == null ? '' : '<a href="'.$weblink.'" target="_blank" style="margin-right:10px"><i class="fa fa-globe" style="margin-right:3px"></i> Web site</a>'  !!}
                </div>
                               <!-- /.description-block -->
            </div>

        @unless($price=='soon')

            <div class="col-sm-4 item-actions" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-item-type="theme" style="text-align: center">
                @if($activation_requied)
                    @if($buylink != null)
                        <a href="{{ $buylink }}" class="btn btn-block btn-success btn-sm"  target="_blank"><i class="fa fa-cart-plus" style="margin-right:10px"></i> {{ trans("admin.BuyNow") }}</a>
                    @endif
                    <a href="javascript:;" class="btn btn-block btn-warning btn-sm register-item" data-item-id="{{ $item_id }}" data-item-name="{{ $name }}" data-item-buy="{{ $buylink }}" data-item-img="{{ $icon }}" style="float:right;text-align: left;width: auto;text-align: left;width:auto"><i class="fa fa-unlock" style="margin-right:10px"></i> {{ trans('admin.ActivateCode') }}</a>
                @elseif(!$instaled)
                    <button type="button" class="btn btn-block btn-info btn-sm download-item"  data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}" style="float:right;text-align: left;width: auto;"><i class="fa fa-check" style="margin-right:10px"></i> {{ trans('admin.download') }}</button>
                @elseif($update_required)
                    <button type="button" class="btn btn-block btn-success btn-sm download-item" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}" style="float:right;text-align: left;width: auto;"><i class="fa fa-download" style="margin-right:10px"></i> {{ trans('admin.download') }} v.{{$version}}</button>
                @elseif($active)
                    <button type="button" class="btn btn-block btn-default btn-sm disabled" style="float:right;text-align: left;width: auto"><i class="fa fa-check"></i> {!! trans("admin.Activated") !!}</button>
                     <a href="{{  action('Admin\ThemesController@settings', [$code]) }}?t={{ $key }}"  class="btn btn-block btn-warning  btn-sm" style="float:right;text-align: left;width: auto;margin: 0 10px 0 0;"><i class="fa fa-cog" style="margin-right:0"></i></a>
                 @else
                    <button type="button" class="btn btn-block btn-info btn-sm activate-item" style="float:right;text-align: left;width: auto;"><i class="fa fa-check" style="margin-right:10px"></i> {{ trans('admin.Install') }}</button>
                @endif
            </div>

        @endunless
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
