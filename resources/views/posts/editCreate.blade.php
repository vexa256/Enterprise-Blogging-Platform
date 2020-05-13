@extends("app")
@section('head_title', trans('addpost.edit', ['type' => $post->title ]).' | '.get_buzzy_config('sitename'))
@section('body_class', 'mode-add')
@section("header")
@include('posts.editor-header')
@endsection

@section("content")
    <div class="buzz-container">

        {!! Form::open(array('action' => array('PostEditorController@editPost', $post->id), 'method' => 'POST', 'onsubmit' => 'return false', 'enctype' => 'multipart/form-data')) !!}
        <div class="global-container container add-container buzzeditor edit-mode"  style="background: #fcfcfc;">
    
            <div class="content"  style="background: #fff;">
                <div class="question-post-form" data-type="{{ $post_type }}">
                    <fieldset>
                        <div class="clear"></div>
                        <section class="form">
                            <div>
                                @include('posts.slug-wrap')
                                <legend>{{ trans('addpost.title') }}</legend>
                            </div>

                            <div class="cd-form">
                                {!! Form::text('headline', $post->title, ['class' => 'cd-input title-input', 'style' => 'margin-bottom:10px', 'placeholder' => trans('addpost.titleplace')]) !!}
                                <select id="tagcats" class="demo-default" name="category" multiple placeholder="{{ trans('addpost.categories') }}">
                                    @foreach(\App\Categories::byMain()->byType($post_type)->byActive()->byOrder()->get() as $ci => $categorys)
                                        <optgroup label="">
                                            <option value="{{ $categorys->id.',' }}" {{ strpos($post->categories, '"'.$categorys->id.',"') ? 'selected' : '' }}>{{ $categorys->name }}</option>
                                            @foreach(\App\Categories::byType($categorys->id)->orderBy('name')->get() as  $i => $cat)
                                                <option value="{{ $categorys->id .','. $cat->id.',' }}"  {{ strpos($post->categories, '"'.$categorys->id .','. $cat->id.',"')  ? 'selected' : ''}}><b>{{ $categorys->name }}</b> / {{ $cat->name }}</option>
                                                @foreach(\App\Categories::byType($cat->id)->orderBy('name')->get() as  $io => $catq)
                                                    <option value="{{ $categorys->id .','. $cat->id .','. $catq->id.',' }}" {{ strpos($post->categories, '"'.$categorys->id .','. $cat->id.','. $catq->id.',"')  ? 'selected' : ''}}><strong>{{ $categorys->name }}</strong> / <b>{{ $cat->name }}</b> / {{ $catq->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                             <legend>{{ trans('addpost.desc') }}</legend>
                            <div class="cd-form">
                                {!! Form::textarea('description', $post->body , ['class' => 'cd-input ','style' => 'height:80px', 'placeholder' =>  trans('addpost.descplace')]) !!}
                            </div>

                        </section>
                        @if($post_type=='list')
                        <section class="form">
                            <legend>{{ trans('addpost.listtype') }}</legend>
                            <div class="lists-types">
                                <a class="button @if($post->ordertype=='asc') button-gray selected @else button-white @endif" data-order="asc">
                                    <i class="fa fa-sort-numeric-asc"></i>
                                    <strong>{{ trans('addpost.listasc') }}</strong>
                                </a>
                                <a class=" button @if($post->ordertype=='desc') button-gray selected @else button-white @endif" data-order="desc">
                                    <i class="fa fa-sort-numeric-desc"></i>
                                    <strong>{{ trans('addpost.listdesc') }}</strong>
                                </a>
                                <a class=" button  @if($post->ordertype==null) button-gray selected @else button-white @endif last" data-order="none">
                                    <i class="fa fa-list-ul"></i>
                                    <strong>{{ trans('addpost.normallist') }}</strong>
                                </a>

                            </div>
                        </section>
                        @endif

                        @if($post_type=='quiz')
                            <section class="form" style="display: none">
                                <legend>{{ trans('buzzyquiz.quiztype') }}</legend>
                                <div class="lists-types">
                                    <a href="{{ action('PostEditorController@showPostCreate', ['new'=>'quiz']) }}" class="button {{ Request::query('qtype')=='trivia' ?  'button-white' : 'button-gray selected' }}"  style="width:48%" data-order="persinalty">
                                        <i class="fa fa-info-circle"></i>
                                        <strong>{!!  trans('buzzyquiz.persinalty')  !!}</strong>
                                    </a>
                                    <a href="{{ action('PostEditorController@showPostCreate', ['new'=>'quiz', 'qtype'=>'trivia']) }}" class=" button {{ Request::query('qtype')=='trivia' ? 'button-gray selected' : 'button-white' }} last" style="width:48%" data-order="trivia">
                                        <i class="fa fa-check-circle"></i>
                                        <strong>{!!  trans('buzzyquiz.trivia')  !!}</strong>
                                    </a>

                                </div>
                            </section>

                            @if($post->ordertype!=='trivia')
                            <section class="form last" id="addnew"  style="border-bottom: 1px solid #e3e3e3;">


                                <legend>{{ trans('buzzyquiz.quizresults') }}</legend>

                                <div id="results">
                                    @foreach($entriesquizresults as $key => $entry)

                                    @include('_forms._buzzyquiz.__addresultform', ['entry' => $entry])

                                    @endforeach
                                </div>


                                <a class="submit-button button button-rosy button-big button-full entry_fetch" style="width:100%;float:none;padding-left:0;padding-right:0;" data-method="Get" data-target="results" data-puttype="append" data-type="resultform" href="{{ action('FormController@addnewform') }}?addnew=result" ><i class="fa fa-check-circle-o"></i>{{ trans('addpost.add', ['type' => trans('buzzyquiz.result')]) }}</a>
                                <br><br><br><br>
                            </section>
                            @endif
                        @endif

                        <section class="form">
                            <legend>{{ trans('addpost.entries', ['type' => "" ]) }}</legend>
                            <div id="entries">
                                @if($post_type=='quiz')

                                    @foreach($entriesquizquest as $key => $entry)

                                    @include('_forms._buzzyquiz.__addquestionform', ['entry' => $entry])

                                    @endforeach

                                @else

                                    @include('posts.editentrylistCreate')

                                @endif
                            </div>
                            @if($post_type=='quiz')
                                <a class="submit-button button button-blue button-full entry_fetch"  style="width:100%;float:none;padding-left:0;padding-right:0;" data-method="Get" data-target="entries" data-puttype="append" data-type="questionform" href="{{ action('FormController@addnewform') }}?addnew=question{{ Request::query('qtype')=='trivia' ? '&qtype=trivia' : '' }}"><i class="fa fa-question-circle"></i>{{ trans('addpost.add', ['type' => trans('buzzyquiz.question')]) }}</a>


                                <div class="clear"></div>
                                <br><br><br>
                            @endif
                        </section>

                        @unless($post_type=='quiz')
                        <section class="form last" id="addnew">
                            @include('posts.add-entry')
                        </section>
                        @endunless
                        <div class="clear"></div>

                    </fieldset>

                </div>

            </div>
            @include('posts.create-sidebar')


        </div>
   
        {!! Form::close() !!}
    </div>
@endsection
@section("footer")
    @include('posts.editor-footer')
@endsection