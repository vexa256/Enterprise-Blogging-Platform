@extends("_admin.adminapp")
@section('header')
<!-- DataTables -->
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.bootstrap.min.css">
@endsection
@section("content")
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {!! trans("admin.Users")  !!}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {!! trans("admin.dashboard")  !!}</a></li>
        <li class="active">{!! trans("admin.Users")  !!}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 5%">{!! trans("admin.Tcon")  !!}</th>
                            <th style="width: 30%">{!! trans("admin.User")  !!}</th>
                            <th style="width: 20%">{!! trans("admin.Email")  !!}</th>
                            <th style="width: 15%">{!! trans("admin.Status")  !!}</th>
                            <th style="width: 10%">{!! trans("admin.JoinedAt")  !!}</th>
                            <th style="width: 10%">{!! trans("admin.LastSeen")  !!}</th>
                            <th style="width: 10%">{!! trans("admin.Actions")  !!}</th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->


@endsection
@section('footer')
    <script src="{{ asset('assets/plugins/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <script>
        $(function() {

            $('#table').dataTable({
                order: [[ 4, 'asc' ]],
                language: {
                    "sDecimal":        ",",
                    "sEmptyTable":     "{!! trans("admin.sEmptyTable")  !!}",
                    "sInfo":           "{!! trans("admin.sInfo")  !!}",
                    "sInfoEmpty":      "{!! trans("admin.sInfoEmpty")  !!}",
                    "sInfoFiltered":   "{!! trans("admin.sInfoFiltered")  !!}",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ".",
                    "sLengthMenu":     "{!! trans("admin.sLengthMenu")  !!}",
                    "sLoadingRecords": "{!! trans("admin.sLoadingRecords")  !!}",
                    "sProcessing":     "{!! trans("admin.sProcessing")  !!}",
                    "sSearch":         "{!! trans("admin.sSearch")  !!}",
                    "sZeroRecords":    "{!! trans("admin.sZeroRecords")  !!}",
                    "oPaginate": {
                        "sFirst":    "{!! trans("admin.sFirst")  !!}",
                        "sLast":     "{!! trans("admin.sLast")  !!}",
                        "sNext":     "{!! trans("admin.sNext")  !!}",
                        "sPrevious": "{!! trans("admin.sPrevious")  !!}"
                    },
                    "oAria": {
                        "sSortAscending":  "{!! trans("admin.sSortAscending")  !!}",
                        "sSortDescending": "{!! trans("admin.sSortDescending")  !!}"
                    }
                },
                processing: true,
                serverSide: true,
                autoWidth: false,
                   ajax: {
                    "url": '{{ action("Admin\\UsersController@getdata") }}@if($type)?only={{ $type }}@endif',
                    "data": function ( ) {
                        setTimeout(function(){   BuzzyAdmin.init(); }, 2000);
                    }
                },
                columns: [
                    {data: 'icon', name: 'icon', orderable: false,  searchable: false},
                    {data: 'username', name: 'username', orderable: false},
                    {data: 'email', name: 'email', orderable: false},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'updated_at', name: 'updated_at', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection