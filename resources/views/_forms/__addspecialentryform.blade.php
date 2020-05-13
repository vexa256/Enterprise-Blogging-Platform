<div class="entry" data-type="{{ $typeofwidget }}" @if(isset($entry->id)) data-entry-id="{{ $entry->id }}" @endif>
    @include('_forms.__entryactions')
    <h3><i class="fa {{ $iconofwidget }}"></i> {{ $titleofwidget }}</h3>
    <div class="inpunting"  @if(isset($entry->video)) style="display: none;" @endif>
        <div class="getvideoinput">
        {!! Form::text(null, null, ['class' => 'cd-input', 'placeholder' => $urlto]) !!}
        <button class="button button-blue get-button create_embed" data-type="{{ $typeofwidget }}">{{ trans('updates.get') }} <i class="fa fa-download"></i></button>
        </div>
    </div>
    <div class="embedarea @if(empty($entry->video)) hide @endif ">
        <div class="inpunting ordering">
            <button class="order-number button button-gray">1</button>
            {!! Form::text(null, isset($entry->title) ? $entry->title : null, ['data-type' => 'title', 'class' => 'cd-input ', 'placeholder' => trans('addpost.entry_titleop')]) !!}
        </div>
        {!! Form::hidden(null, isset($entry->video) ? $entry->video : null, ['data-type' => 'video', 'class' => 'cd-input cd-input-video']) !!}
        <div class="inpunting videoembed">
            @if(isset($entry->video))
                 {!! parse_post_embed($entry->video) !!}
            @endif
        </div>

        <div class="moredetail text">
            <div class="detailhide" style="display:none">
                <div class="inpunting">
                    {!! Form::textarea(null, isset($entry->body) ? $entry->body : null, ['data-type' => 'body', 'class' => 'cd-input message','id' => 'edit', 'placeholder' => trans('addpost.entry_body')]) !!}
                </div>
            </div>
            <a href="javascript:;" class="trigger"><span class="down">{{ trans('addpost.mored') }} <i class="fa fa-angle-down"></i></span><span class="up">{{ trans('addpost.lessd') }}  <i class="fa fa-angle-up"></i></span></a>
        </div>
    </div>
</div>
