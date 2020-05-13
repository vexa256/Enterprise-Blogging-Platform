<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Post;
use App\Http\Requests;

class RssController extends Controller
{

    public function index($type)
    {
        if ($type == 'sitemap') {
            $posts = Post::approve('yes')->byPublished()->limit(50)->get();
            $categories = Categories::get();

            return  response()->view('vendor.sitemap', compact('posts', 'categories'))->header('Content-Type', 'xml');
        }

        $posts = $this->getdata($type);
        if (count($posts) == 0) {
            \Session::flash('error.message',  trans('index.emptyplace'));
            return redirect()->back();
        }

        return  response()->view('vendor.rss', compact('posts'))->header('Content-Type', 'text/xml');
    }


    public function fbinstant()
    {

        $posts = Post::approve('yes')->where('type', '!=', 'quiz')->byPublished()->limit(150)->get();

        return  response()->view('vendor.instant-rss', compact('posts'))->header('Content-Type', 'text/rss');
    }


    public function getdata($type)
    {
        if ($type == 'index') {
            $posts = Post::approve('yes')->byPublished()->limit(50)->get();
        } elseif ($type == 'bugununeniyileri') {
            $posts    = Post::forhome()->activeTypes()->byPublished()->getStats('one_day_stats', 'DESC', 10)->get();
        } else {
            $categories = Categories::where("name_slug", $type)->get();

            if (!isset($categories)) {
                return redirect('/');
            }


            $categoryarray = array();
            foreach ($categories as $categor) {
                array_push($categoryarray, $categor->id);
            }
            $this->categoryarray = $categoryarray;


            $posts = Post::where(function ($query) {
                foreach ($this->categoryarray as $kk => $value) {
                    if ($kk == 0) {
                        $query->where('categories', 'LIKE',  '%"' . $value . ',%')->orWhere('categories', 'LIKE',  '%,' . $value . ',%');
                    } else {
                        $query->orWhere('categories', 'LIKE',  '%"' . $value . ',%')->orWhere('categories', 'LIKE',  '%,' . $value . ',%');
                    }
                }
            })->byPublished()->approve('yes')->take(50)->get();
        }


        return $posts;
    }

    public function json($type)
    {
        $category = Categories::where("id", $type)->first();
        if (!$category) {
            return response()->json("");
        }

        if ($category->main == "1") {
            $posts = Post::byType($category->type)
                ->approve('yes')
                ->byPublished()
                ->take(6)->get();
        } else {
            $posts = Post::where('categories', 'LIKE',  '%,' . $category->id . '"%')->approve('yes')->orwhere('categories', 'LIKE',  '%,' . $category->id . ',%')->approve('yes')
                ->byPublished()->take(6)->get();
        }

        if (count($posts) == 0) {
            return response()->json("");
        }
        foreach ($posts as $key => $post) {
            $postsre[] = array('slug' => generate_post_url($post), 'title' => $post->title, 'thumb' =>  makepreview($post->thumb, 's', 'posts'));
        }

        return response()->json($postsre);
    }
}
