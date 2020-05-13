@extends("_admin.adminapp")

@section("content")
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('themes.themes') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li class="active">{{ trans('themes.themes') }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<div class="row">
    @foreach($themes as $key =>  $theme)
        <div class="col-lg-4 col-md-6 col-xs-12">
        @include('_admin._particles.theme_box', $theme)
        </div>
    @endforeach
</div>

</section><!-- /.content -->
@endsection
