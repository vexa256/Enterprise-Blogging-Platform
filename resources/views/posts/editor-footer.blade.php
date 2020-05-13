<script src="{{ asset('assets/plugins/editor/module.min.js') }}"></script>
<script src="{{ asset('assets/plugins/editor/hotkeys.min.js') }}"></script>
<script src="{{ asset('assets/plugins/editor/simditor.js') }}"></script>
<script>
     BuzzyEditorlang = {
        'lang_1': '{!!  trans('updates.BuzzyEditor.lang.lang_1') !!}',
        'lang_2': '{!! trans('updates.BuzzyEditor.lang.lang_2') !!}',
        'lang_3': '{!! trans('updates.BuzzyEditor.lang.lang_3') !!}',
        'lang_4': '{!! trans('updates.BuzzyEditor.lang.lang_4') !!}',
        'lang_5': '{!! trans('updates.BuzzyEditor.lang.lang_5') !!}',
        'lang_6': '{!! trans('updates.BuzzyEditor.lang.lang_6') !!}',
        'lang_7': '{!! trans('updates.BuzzyEditor.lang.lang_7') !!}',
        'lang_8': '{!! trans('updates.BuzzyEditor.lang.lang_8') !!}',
        'lang_9': '{!! trans('updates.BuzzyEditor.lang.lang_9') !!}',
        'lang_10': '{!! trans('updates.BuzzyEditor.lang.lang_10') !!}',
        'lang_11': '{!! trans('updates.BuzzyEditor.lang.lang_11') !!}',
        'lang_12': '{!! trans('updates.BuzzyEditor.lang.lang_12') !!}',
        'lang_13': '{!! trans('updates.BuzzyEditor.lang.lang_13') !!}',
        'lang_14': '{!! trans('updates.BuzzyEditor.lang.lang_14') !!}',
        'lang_15': '{!! trans('updates.BuzzyEditor.lang.lang_15') !!}',
        'lang_16': '{!! trans('updates.BuzzyEditor.lang.lang_16') !!}',
        'errorl': '{!! trans('updates.error') !!}'
    };

     BuzzyEditorVars = {
        'image_upload_request': '{{ route("upload_image_request") }}',
        'fetch_video_request': '{{ route("fetch_video_request") }}',
        'current_publish_server_time': '{{ Carbon\Carbon::now() }}',
    };

     Simditor.i18n = {
        'en_EN': {
            'normalText': '{!! trans('updates.BuzzyEditor.TextEditor.normalText') !!}',
            'title': '{!! trans('updates.BuzzyEditor.TextEditor.title') !!}',
            'blockquote': '{!! trans('updates.BuzzyEditor.TextEditor.blockquote') !!}',
            'bold': '{!! trans('updates.BuzzyEditor.TextEditor.bold') !!}',
            'italic': '{!! trans('updates.BuzzyEditor.TextEditor.italic') !!}',
            'link': '{!! trans('updates.BuzzyEditor.TextEditor.link') !!}',
            'text': '{!! trans('updates.BuzzyEditor.TextEditor.text') !!}',
            'linkText': '{!! trans('updates.BuzzyEditor.TextEditor.linkText') !!}',
            'linkUrl': '{!! trans('updates.BuzzyEditor.TextEditor.linkUrl') !!}',
            'removeLink': '{!! trans('updates.BuzzyEditor.TextEditor.removeLink') !!}',
            'ol': '{!! trans('updates.BuzzyEditor.TextEditor.ol') !!}',
            'ul': '{!! trans('updates.BuzzyEditor.TextEditor.ul') !!}',
            'strikethrough': '{!! trans('updates.BuzzyEditor.TextEditor.strikethrough') !!}',
            'underline': '{!! trans('updates.BuzzyEditor.TextEditor.underline') !!}',
        }
    };

   

</script>
<script src="{{ asset('assets/js/buzzyeditor.min.js') }}" type="text/javascript"></script>
