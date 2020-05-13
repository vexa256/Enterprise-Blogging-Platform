@extends('installer.layouts.master')

@section('container')
    @if(!$activation)
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                @lang('installer.requirements.title')
            </h3>
        </div>
        <div class="panel-body">
            <div class="bs-component">
                <ul class="list-group">
                    @foreach($requirements['requirements'] as $element => $enabled)
                    <li class="list-group-item">
                        @if($enabled)
                            <span class="badge badge-success">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="glyphicon glyphicon-remove"></i>
                            </span>
                        @endif
                        {{ $element }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @if(!isset($requirements['errors']))
                <a class="btn btn-success" href="{{ url('installer/permissions') }}">
                    @lang('installer.next')
                </a>
            @endif
        </div>
    </div>
    @endif

@stop
@section('js')
    <script>
        var buzzy_item_id ="{{ config('buzzy.item_id') }}";
        var buzzy_base_url ="{{ url('/') }}";
        var buzzy_current_url ="{{ url()->current() }}";
    </script>
    <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
    @if($activation)
    <script src="{{ asset('assets/plugins/adminlte/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script>
      $(document).ready(function() {
            $(window).trigger('register:toggle');
        });
    </script>
    @endif
@endsection