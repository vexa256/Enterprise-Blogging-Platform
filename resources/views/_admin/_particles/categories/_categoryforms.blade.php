<div class="box ">
    <div class="nav-tabs-custom">
        @if(!isset($category->id))
        <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab" aria-expanded="true">{{ trans('admin.AddMainCategory') }}</a></li>
            <li class=""><a href="#glyphicons" data-toggle="tab" aria-expanded="false">{{ trans('admin.AddSubCategory') }}</a></li>
        </ul>
        @else 
        <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-<i class=material-icons>library_books</i>"></i> <b>{{ trans('admin.edit') }} : {{ $category->name }}</b>  </li>
        </ul>
        @endif
        <div class="tab-content">
            <!-- Font Awesome Icons -->
            <div class="tab-pane @if(isset($category->id)) @if($category->main==1) active @endif @else active @endif" id="fa-icons">
                <!-- form start -->
                {!! Form::open(array('action' => array('Admin\CategoriesController@addnew'), 'method' => 'POST')) !!}
                <div class="box-body">
                    <input type="hidden" name="id" value="{{ isset($category->id) ? $category->id : null }}">
                   
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.Categoryname')) !!}
                        {!! Form::text('name',  isset($category->name) ? $category->name : null, ['id' => 'name', 'class' => 'form-control input-lg', 'placeholder' => trans('admin.Entercategoryname') ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name_slug',trans('admin.CategorySlug')) !!}
                        {!! Form::text('name_slug',  isset($category->name_slug) ? $category->name_slug : null, ['id' => 'name_slug', 'class' => 'form-control input-lg', 'placeholder' => trans('admin.Entercategoryslug') ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('posturl_slug',trans('admin.PostUrlSlug')) !!}
                        {!! Form::text('posturl_slug',  isset($category->posturl_slug) ? $category->posturl_slug : null, ['id' => 'posturl_slug', 'class' => 'form-control input-lg', 'placeholder' => trans('admin.Enterpoststitleslug')]) !!}
                        <div class="help">{{ url("/") }}/<code>post_url_slug</code>/your-post-title</div>
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('type', 'Post Type') !!}
                        {!! Form::select('type', get_post_types(), isset($category->type) ? $category->type : null , ['class' => 'form-control'])  !!}

                        You can activate/deactivate post types from <a href="/admin/plugins" target="_blank">plugins page</a>
                    </div>

                    <div class="form-group">
                        {!! Form::label('description',trans('admin.CategoryDescription')) !!}
                        <textarea id="description" class="form-control" name="description" cols="50" rows="3" spellcheck="false">{{ isset($category->description) ? $category->description : null }}</textarea>
                    </div>
                    <div class="form-group">
                        {!! Form::label('icon', 'Icon') !!}
                        {!! Form::text('icon',  isset($category->icon) ? $category->icon : null, ['id' => 'icon', 'class' => 'form-control input-lg', 'placeholder' => 'Leave empty for no icon']) !!}
                        For Modern Theme: Find yor font code <a href="https://material.io/icons/" target="_blank">here.</a> Example code: <code>&lt;i class="material-icons"&gt;library_books&lt;/i&gt;</code><br>
                        For Classic Theme: Find yor font code <a href="http://fontawesome.io/icons/" target="_blank">here.</a> Example code: <code>&lt;i class="fa fa-pencil-square-o"&gt;&lt;/i&gt;</code><br>
                    </div>
                   
                    <div class="form-group">
                        {!! Form::label('menu_icon_show', 'Show Icon on Menu') !!}
                        {!! Form::select('menu_icon_show', [null => trans('admin.no'), 'yes' => trans('admin.yes')], isset($category->menu_icon_show) ? $category->menu_icon_show : null , ['class' => 'form-control'])  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('order', 'Menu Order') !!}
                        {!! Form::text('order',  isset($category->order) ? $category->order : null, ['id' => 'menu_order', 'class' => 'form-control input-lg', 'placeholder' => 'Category will show up with this order number']) !!}
                        Leave empty if you don't want to show this category on main menu
                    </div>
                   
                    @if(isset($category->id)) 
                    <div class="form-group">
                        {!! Form::label('disabled', trans('admin.disable')) !!}
                        {!! Form::select('disabled', ['0' => trans('admin.no'), '1' => trans('admin.yes')], isset($category->disabled) ? $category->disabled : null , ['class' => 'form-control'])  !!}
                    </div>
                    @endif 
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"> {{ trans('admin.Submit') }}</button>
                    @if(isset($category->id)) 
                        <a href="/admin/categories" class="btn btn-default pull-right">Cancel</a>
                    @endif 
                </div>
                {!! Form::close() !!}
            </div>
        
            <!-- glyphicons-->
            <div class="tab-pane @if(isset($category->id)) @if($category->main==0 or $category->main==2) active @endif @endif" id="glyphicons">

                <!-- form start -->
                {!! Form::open(array('action' => array('Admin\CategoriesController@addnew'), 'method' => 'POST')) !!}
                <div class="box-body" >
                    <input type="hidden" name="id" value="{{ isset($category->id) ? $category->id : null }}">

                    <div class="form-group">
                        {!! Form::label('name',trans('admin.Categoryname')) !!}
                        {!! Form::text('name',  isset($category->name) ? $category->name : null, ['id' => 'name', 'class' => 'form-control input-lg', 'placeholder' => trans('admin.Entercategoryname') ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name_slug',trans('admin.CategorySlug')) !!}
                        {!! Form::text('name_slug',  isset($category->name_slug) ? $category->name_slug : null, ['id' => 'name_slug', 'class' => 'form-control input-lg', 'placeholder' => trans('admin.Entercategoryslug') ]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description',trans('admin.CategoryDescription')) !!}
                        <textarea id="description" class="form-control" name="description" cols="50" rows="3" spellcheck="false">{{ isset($category->description) ? $category->description : null }}</textarea>
                    </div>
                    <div class="form-group">
                        {!! Form::label('parent_cat',trans('admin.CategoryParent')) !!}
                        <select class="form-control" name="parent_cat">
                            @foreach(\App\Categories::where('main', "1")->orderBy('order', 'asc')->get() as $alt_category)
                                <optgroup label="">
                                    <option value="{{ $alt_category->id }}" {{ isset($category->type) && $category->type ==$alt_category->id ? 'selected' : '' }}>{{ $alt_category->name }}</option>
                                    @foreach(\App\Categories::where('type', $alt_category->id)->orderBy('name')->get() as $altalt_category)
                                        <option value="{{ $altalt_category->id }}" {{ isset($category->type) && $category->type ==$altalt_category->id ? 'selected' : '' }}>{{ $alt_category->name }} / {{ $altalt_category->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>


                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"> {{ trans('admin.Submit') }}</button>
                        @if(isset($category->id)) 
                        <a href="/admin/categories" class="btn btn-default pull-right">Cancel</a>
                    @endif 
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /#ion-icons -->

        </div>
        <!-- /.tab-content -->
    </div>



</div>