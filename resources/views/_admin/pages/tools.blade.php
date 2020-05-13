@extends("_admin.adminapp")
@section('header')
@endsection
@section("content")
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('v3.tools') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  {{ trans('admin.dashboard') }}</a></li>
        <li class="active"> {{ trans('admin.Tools') }}</li>
    </ol>
</section>

<section class="content">

    <div class="row">

        <div class="col-md-3">
            <div class="box box-default">
            <div class="box-header with-border">
            <h3 class="box-title">{{ trans('v3.tmpfolder') }}</h3>
        
            <div class="box-tools pull-right" style="margin-top:5px">
                {!! $file_system === 's3' ? ' <span class="badge mar-y bg-red">S3 storage</span>': '<span class="badge bg-red">Local storage</span>' !!} 
            </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
                <div class="small-box bg-white pad1y">
                    <div class="inner">
                    <h3>{{ $file_count }} <sup style="font-size: 20px">{{ trans('v3.files') }}</sup></h3>
        
                    <p class="text-black">{{ $folder_size }}MB</p>
                    </div>
                    <div class="icon">
                    <i class="fa fa-files-o"></i>
                    </div>

                    <span class="help-block"> 
                        {{ trans('v3.files_info') }}
                    </span>
                </div>
                <script type="text/javascript">
                    function confirm_delete() {
                      return confirm("{{ trans('updates.BuzzyEditor.lang.lang_1') }}");
                    }
                </script>
                <a href="{{ action('Admin\ToolsController@removeTmpFolder') }}" 
                class="btn btn-block {{ $file_count > 0 ? 'btn-danger' : 'btn-default' }} btn-lg" onclick="return confirm_delete()"> <i class="fa fa-trash"></i>  
                {{ trans('v3.delete_files') }} 
                </a>
                    
                </a>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
            

            
    </div>


 
</section>
@endsection
@section("footer")
   
@endsection