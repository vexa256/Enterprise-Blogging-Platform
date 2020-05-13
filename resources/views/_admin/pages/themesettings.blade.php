@extends("_admin.adminapp")
@section('header')
   <!-- colorpicker -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    @endsection
@section("content")
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('themes.themes') }}  > {{ $theme['name'] }} > {{ trans('admin.Settings') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li><a href="/admin/themes"> {{ trans('themes.themes') }}</a></li>
        <li class="active">{{ $theme['name'] }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    {!!   Form::open(array('action' => 'Admin\ConfigController@setconfig', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}

    @include('_admin._particles.theme_settings.'. $theme['code'])

    <div class="row">
        <div class="col-md-6 col-lg-6">

            <input type="submit" value="{{ trans('admin.SaveSettings') }}" class="btn btn-block btn-info btn-lg">

        </div><!-- /.col -->
    </div><!-- /.row -->
    {!! Form::close() !!}

</section><!-- /.content -->

@endsection
@section("footer")
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