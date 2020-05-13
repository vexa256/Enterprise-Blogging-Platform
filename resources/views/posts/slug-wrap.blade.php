<div class="slug-container">
    <span class="post_slug_text">
        <span class="post_slug">{{ isset($post) ? $post->slug : '...' }}</span>
        <span class="post_slug_edit"> <i class="fa fa-edit"></i></span>
    </span>
    <span class="post_slug_input">
        <input class="selectize-input" type="text" id="post_slug_input" value="{{ isset($post) ? $post->slug : '' }}">
        <input type="button" value="Save" class="button button-white" id="post_slug_save" onclick="return false">
        <input type="button" value="X" class="button button-white" id="post_slug_use_title" onclick="return false">
    </span>
</div>