@php($categories = \App\Categories::whereIn("main", ['1', '2'])->where("disabled", '0')->orderBy('order')->get())

<?php 
$typeos = [];
foreach ($categories as $cat) {
    $typeos[$cat->id] = $cat->name;

    foreach (\App\Categories::byType($cat->id)->orderBy('name')->get() as $cata) {
        $typeos[$cata->id] = "---- " . $cata->name;
    }
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-remove"></i></button>
    <h4 class="modal-title">{!! trans("admin.BuzzyHomepageBuilder")  !!}</h4>
</div>
<div class="modal-body">
    <div class="col-lg-6 col-xs-3">
        <h2 class="control-label"> {!! trans("admin.Column")  !!} 1</h2>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.Section1Title")  !!}</label>
            <input type="text" class="form-control input-lg" name="HomeColSec1Tit1" value="{{ get_buzzy_config('HomeColSec1Tit1') }}">
        </div>
        <div class="form-group">

            <label class="control-label">{!! trans("admin.SelectedTypesorCategories")  !!}</label>
            {!! Form::select('HomeColSec1Type1[]', $typeos, json_decode(get_buzzy_config('HomeColSec1Type1')), ['class' => 'form-control','style' => 'height:220px','multiple' => 'multiple'])  !!}
        </div>

    </div>
    <div class="col-lg-4 col-xs-3">
        <h2 class="control-label">{!! trans("admin.Column")  !!} 2</h2>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.Section2Title")  !!}</label>
            <input type="text" class="form-control input-lg" name="HomeColSec2Tit1" value="{{ get_buzzy_config('HomeColSec2Tit1') }}">
        </div>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.SelectedTypesorCategories")  !!}</label>
            {!! Form::select('HomeColSec2Type1[]', $typeos, json_decode(get_buzzy_config('HomeColSec2Type1')), ['class' => 'form-control','style' => 'height:220px','multiple' => 'multiple'])  !!}
        </div>
    </div>
    <div class="col-lg-2 col-xs-3">
        <h2 class="control-label">{!! trans("admin.Column")  !!} 3</h2>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.TrendingsOnOff")  !!}</label>
            {!! Form::select('HomeCol3Trends', ['true' => trans("admin.on"), 'false' => trans("admin.of")], get_buzzy_config('HomeCol3Trends'), ['class' => 'form-control'])  !!}
        </div>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.Section3Title")  !!}</label>
            <input type="text" class="form-control input-lg" name="HomeColSec3Tit1" value="{{ get_buzzy_config('HomeColSec3Tit1') }}">
        </div>
        <div class="form-group">
            <label class="control-label">{!! trans("admin.SelectedTypesorCategories")  !!}</label>

            {!! Form::select('HomeColSec3Type1[]', $typeos, json_decode(get_buzzy_config('HomeColSec3Type1')), ['class' => 'form-control','style' => 'height:150px','multiple' => 'multiple'])  !!}
        </div>

    </div>
<div class="clearfix"></div>
</div>