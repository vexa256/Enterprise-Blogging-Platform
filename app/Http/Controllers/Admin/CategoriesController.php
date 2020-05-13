<?php

namespace App\Http\Controllers\Admin;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends MainAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('DemoAdmin', ['only' => ['delete', 'addnew']]);
    }

    public function index(Request $request)
    {
        $categories = Categories::byMain()->orderBy('order')->get();

        $category = "";

        if ($request->query('edit')) {
            $category = Categories::findOrFail($request->query('edit'));
        }

        return view('_admin.pages.categories', compact('categories', 'category'));
    }

    public function delete($id)
    {
        $category = Categories::findOrFail($id);

        $category->delete();

        \Session::flash('success.message', trans("admin.Deleted"));

        return redirect()->back();
    }

    public function addnew(Request $request)
    {

        $inputs = $request->all();
        $v = \Validator::make(
            $inputs, [
                'name' => 'required',
                'name_slug' => 'required',
                'description' => 'max:500'
            ]
        );
      

        if ($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        $type = isset($inputs['type']) ? $inputs['type'] : null;
        $id = $inputs['id'];
        $name_slug = str_slug($inputs['name_slug'], '-');
        $posturl_slug = isset($inputs['posturl_slug']) ? str_slug($inputs['posturl_slug'], '-') : null;

        $parent_cat = isset($inputs['parent_cat']) ? $inputs['parent_cat'] : null;

        if ($id !== null) {
            $category = Categories::findOrFail($id);
        } else {
            $category = new Categories;

            if ($parent_cat === null) {
                $category->main = "1";
            } else {
                $category_parent = Categories::findOrFail($parent_cat);

                // add as sub
                $type = $category_parent->id;
                $category->main = "2";
            }
        }

        $category->order = isset($inputs['order']) ? $inputs['order'] : null;
        $category->name = $inputs['name'];
        $category->name_slug = $name_slug;
        $category->posturl_slug = $posturl_slug;
        $category->description = isset($inputs['description']) ? $inputs['description'] : null;
        $category->type = $type;
        $category->icon = isset($inputs['icon']) ? $inputs['icon'] : null;
        $category->disabled = isset($inputs['disabled']) ? $inputs['disabled'] : "0";
        $category->menu_icon_show = isset($inputs['menu_icon_show']) ? $inputs['menu_icon_show'] : null;
        $category->save();

        if (!empty($inputs['id'])) {
            \Session::flash('success.message', trans("admin.ChangesSaved"));

            return redirect('/admin/categories');
        } else {
            \Session::flash('success.message', trans("admin.ChangesSaved"));

            return redirect()->back();
        }
    }
}
