<?php

namespace App\Http\Controllers\Admin;

use App\Categories;
use App\Events\PostUpdated;
use Carbon\Carbon;
use App\Post;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class PostsController extends MainAdminController
{
    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['approvePost', 'setForHomepage', 'setFeatured', 'deletePost', 'forceDeletePost']]);

        parent::__construct();
    }

    public function features()
    {

        return view('_admin.pages.posts')->with(['title' => trans("admin.FeaturesPost"), 'desc' => '', 'type' => 'features']);
    }

    public function unapprove()
    {
        return view('_admin.pages.posts')->with(['title' => trans("admin.Post"), 'desc' => '', 'type' => 'all']);
    }

    public function all()
    {
        return view('_admin.pages.posts')->with(['title' => trans("admin.AllPost"), 'desc' => '', 'type' => 'all']);
    }

    public function showcatposts($name)
    {
        $cats = Categories::where("name_slug", $name)->first();

        if (!$cats) {
            return redirect()->back();
        }

        return view('_admin.pages.posts')->with(['title' => $cats->name, 'desc' => $cats->name, 'type' => $cats->type]);
    }

    public function approvePost($id)
    {
        $post = Post::findOrFail($id);

        if ($post->approve == 'no') {
            $post->approve = 'yes';
            $post->save();

            try {
                event(new PostUpdated($post, 'Approved'));
            } catch (\Exception $e) {
                //
            }
        } else {
            $post->approve = 'no';
            $post->save();
        }

        \Session::flash('success.message', "");

        return redirect()->back();
    }

    public function setForHomepage($id)
    {
        $post = Post::findOrFail($id);

        if ($post->show_in_homepage == null) {
            $post->show_in_homepage = 'yes';
        } else {
            $post->show_in_homepage = null;
        }

        $post->save();

        \Session::flash('success.message', trans("admin.ChangesSaved"));

        return redirect()->back();
    }

    public function setFeatured($id)
    {
        $post = Post::findOrFail($id);

        if ($post->featured_at == null) {
            $post->featured_at = Carbon::now();
        } else {
            $post->featured_at = null;
        }

        $post->save();

        \Session::flash('success.message', trans("admin.ChangesSaved"));

        return redirect()->back();
    }

    public function deletePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ($post->deleted_at == null) {
            $post->approve = 'no';
            $post->delete();

            try {
                event(new PostUpdated($post, 'Trash'));
            } catch (Exception $e) {
                //
            }
        } else {
            $post->approve = 'yes';
            $post->restore();
        }

        \Session::flash('success.message', trans("admin.ChangesSaved"));

        return redirect()->back();
    }

    public function forceDeletePost($id)
    {
        try {
            $post = Post::withTrashed()->findOrFail($id);

            if ($post->deleted_at !== null) {
                event(new PostUpdated($post, 'Trash'));
            }

            $post->forceDelete();

            \Session::flash('success.message', trans("admin.Deletedpermanently"));
        } catch (Exception $e) {
            \Session::flash('error.message', trans("admin.Deletedpermanently"));
        }

        return redirect()->back();
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getdata(Request $request)
    {

        $typew = $request->query('type');
        $type = $typew;

        $only = $request->query('only');

        $post = Post::leftJoin('users', 'posts.user_id', '=', 'users.id');
        $post->select('posts.*');

        if ($typew == 'all') {
            //not set
        } elseif ($typew !== 'features') {
            $post->where('type', $type);
        } else {
            $post->where("featured_at", '>', '');
        }

        if ($only == 'deleted') {
            $post->onlyTrashed();
        } else {
            $post->where('deleted_at', null);
        }


        if ($only == 'unapprove') {
            $post->where('approve', 'no');
        }

        return Datatables::of($post)

            ->editColumn('thumb', function ($post) {
                return '<img src="' . makepreview($post->thumb, 's', 'posts') . '" width="125">';
            })
            ->editColumn('title', function ($post) {
                return '<a href="' . generate_post_url($post) . '" target=_blank style="font-size:16px;font-weight: 600">
                        ' . $post->title . '
                        </a>
                        <div class="product-meta"></div>
                    ';
            })
            ->editColumn('user', function ($post) {
                return $post->user ? '<div  style="font-weight: 400;color:#aaa">
                                        <a href="/profile/' . $post->user->username_slug . '" target="_blank"><img src="' . makepreview($post->user->icon, 's', 'members/avatar') . '" width="32" style="margin-right:6px">' . $post->user->username . '</a>
                                </div>' : '';
            })
            ->addColumn('approve', function ($post) {

                if ($post->deleted_at !== null) {
                    $fsdfd = '<div class="label label-danger">' . trans("admin.OnTrash") . '</div>';
                } elseif ($post->approve == 'draft') {
                    $fsdfd = '<div class="label label-info" style="background-color: #9c486c !important;">' . trans("admin.DraftPost") . '</div>';
                } elseif ($post->approve == 'no') {
                    $fsdfd = '<div class="label label-info" style="background-color: #9c6a11 !important;">' . trans("admin.AwaitingApproval") . '</div>';
                } elseif ($post->featured_at !== null) {
                    $fsdfd =  '<div class="clear"></div><div class="label label-warning" style="background-color: #9C5D54 !important;">' . trans("admin.FeaturedPost") . '</div>';
                } elseif ($post->approve == 'yes') {
                    $fsdfd = '<div class="label label-info">' . trans("admin.Active") . '</div>';
                }

                if ($post->show_in_homepage == 'yes') {
                    $fsdfd .= '<div class="clear"></div><div class="label label-success">' . trans("admin.Pickedforhomepage") . '</div>';
                }

                if ($post->published_at->getTimestamp() > Carbon::now()->getTimestamp()) {
                    $fsdfd .= '<div class="label bg-gray">' . trans('v3.scheduled_date', ['date' => $post->published_at->format('j M Y, h:i A')])  . '</div>';
                }

                return $fsdfd;
            })
            ->addColumn('action', function ($post) {
                $edion = '<div class="input-group-btn">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Actions <span class="fa fa-caret-down"></span></button>
                                  <ul class="dropdown-menu pull-left" style="left:-100px;  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);">';

                if ($post->deleted_at == null) {
                    if ($post->approve == 'no') {
                        $edion = $edion . '<li><a href="' . action("Admin\PostsController@approvePost",  $post->id) . '"><i class="fa fa-check"></i>  ' . trans("admin.Approve") . '</a></li>';
                    } elseif ($post->approve == 'yes') {
                        $edion = $edion . '<li><a href="' . action("Admin\PostsController@approvePost",  $post->id) . '"><i class="fa fa-remove"></i> ' . trans("admin.UndoApprove") . '</a></li>';
                    }

                    if ($post->featured_at == null) {
                        $edion = $edion .  '<li><a href="' . action("Admin\PostsController@setFeatured",  $post->id) . '"><i class="fa fa-star"></i> ' . trans("admin.PickforFeatured") . '</a></li>';
                    } else {
                        $edion = $edion .  '<li><a href="' . action("Admin\PostsController@setFeatured",  $post->id) . '"><i class="fa fa-remove"></i> ' . trans("admin.UndoFeatured") . '</a></li>';
                    }

                    if ($post->show_in_homepage == null) {
                        $edion = $edion .  '<li><a href="' . action("Admin\PostsController@setForHomepage",  $post->id) . '"><i class="fa fa-dashboard"></i> ' . trans("admin.PickforHomepage") . '</a></li>';
                    } elseif ($post->show_in_homepage == 'yes') {
                        $edion = $edion .  '<li><a href="' . action("Admin\PostsController@setForHomepage",  $post->id) . '"><i class="fa fa-remove"></i>   ' . trans("admin.UndofromHomepage") . '</a></li>';
                    }

                    $edion = $edion .  '<li class="divider"></li>';

                    $edion = $edion .  '<li><a target="_blank" href="/edit/' . $post->id . '"><i class="fa fa-edit"></i> ' . trans("admin.EditPost") . '</a></li>';

                    $edion = $edion .  '<li class="divider"></li>';
                }

                if ($post->deleted_at == null) {
                    $edion = $edion . '<li><a class="sendtrash" href="' . action("Admin\PostsController@deletePost",  $post->id) . '"><i class="fa fa-trash"></i> ' . trans("admin.SendtoTrash") . '</a></li>';
                } else {
                    $edion = $edion . '<li><a href="' . action("Admin\PostsController@deletePost",  $post->id) . '"><i class="fa fa-trash"></i> ' . trans("admin.RetrievefromTrash") . '</a></li>';
                }

                $edion = $edion .  '<li><a class="permanently" href="' . action("Admin\PostsController@forceDeletePost",  $post->id) . '"><i class="fa fa-remove"></i> ' . trans("admin.Deletepermanently") . '</a></li>';

                $edion = $edion .  '</ul>
                            </div>';

                return $edion;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
