@if($updates && (isset($updates['update_required']) && $updates['update_required']) && (isset($updates['version']) && $updates['version']))
<div class="alert alert-success alert-dismissible" style="border-radius:0">
<h4><i class="icon fa fa-check"></i> {{ trans('admin.newupdate') }} 
@if(isset($updates['changelog'])) <a href="{{ $updates['changelog'] }}" target="_blank" class="btn btn-xs btn-google" style="margin-left:20px;text-decoration:none">Change Log <span class="badge badge-danger">v.{{ $updates['version'] }}</span></a>@endif
</h4>
<p> New update is available. <a href="javascript:;" class="download-item" data-item-code="{{ config('buzzy.item_code') }}" data-item-id="{{ config('buzzy.item_id') }}" data-version="{{ $updates['version'] }}">Click here</a>  and get your Buzzy latest version automatically. 
<span class="badge bg-red clearfix" style="margin-left:20px;">Please back up your database and files before update.</span>
</p>
</div>
@endif