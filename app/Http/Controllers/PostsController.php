<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PostsController extends Controller
{
    /**
     * Show a Post
     *
     * @return \Illuminate\View\View
     */
    public function index($catname, $slug)
    {
        $post = get_post_from_url($catname, $slug);

        if (!$post) {
            return redirect('404');
        }

        $publish_from_now = $post->published_at && $post->published_at->getTimestamp() > Carbon::now()->getTimestamp();

        if ($post->approve !== 'yes' || $publish_from_now) {
            if (!Auth::check() || Auth::user()->usertype != 'Admin' && Auth::user()->id != $post->user->id) {
                return redirect('404');
            }
        }
  
        $this->postHit($post);

        $entries = $post->entries();
        if ($post->pagination == null) {
            $entries =  $entries->where('type', '!=', 'answer')->orderBy('order', 'asc')->get();
        } else {
            $entries =  $entries->where('type', '!=', 'answer')->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->paginate($post->pagination);
        }

        $entriesquizquest = "";
        $entriesquizresults = "";
        if ($post->type == 'quiz') {
            $entriesquizquest = $post->entries()->where('type', 'quizquestion')->oldest("order")->get();
            $entriesquizresults = $post->entries()->byType("quizresult")->oldest("order")->get();
        }
        //where('published_at', '>=', Carbon::yesterday())->
        $lastTrending = Post::approve('yes')->where('posts.id', '!=', $post->id)->activeTypes()->byPublished()->getStats('one_day_stats', 'DESC', 10)->get();

        $lastFeatures = Post::approve('yes')->where('type', $post->type)->activeTypes()->byPublished()->getStats('one_day_stats', 'DESC', 6)->get();


        $reactions = false;
        if (get_buzzy_config('p_reactionform') == 'on') {
            $reactions = $post->reactions;
        }
        $commentson = true;
        
        return view(
            "pages/post", compact(
                'post',
                'entries',
                'reactions',
                'entriesquizquest',
                'entriesquizresults',
                'lastTrending',
                'lastFeatures',
                'commentson',
                'publish_from_now'
            )
        );
    }


    /**
     * Show a Amp Post
     *
     * @return \Illuminate\View\View
     */
    public function amp($catname, $id)
    {
        $post = Post::where('id', $id)->byPublished()->first();
    
        if (!$post || $post->type == 'quiz' || $post->type == 'poll') {
            abort(404);
        }

        if ($post->approve !== 'yes') {
            if (!Auth::check() || Auth::user()->usertype != 'Admin' && Auth::user()->id != $post->user->id) {
                abort(404);
            }
        }

        $entries = $post->entries();
        $entries =  $entries->where('type', '!=', 'answer')->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->get();


        $lastFeatures = Post::approve('yes')->where('type', $post->type)->activeTypes()->byPublished()->getStats('one_day_stats', 'DESC', 6)->get();

        return view("amp/post", compact('post', 'entries', 'lastFeatures'));
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function ajax_previous(Request $request)
    {
        $post = "";
        $id = $request->query('id');
        $type = $request->query('type');
        $pid = $request->query('pid');

        $posta = Post::byPublished()->find($id);

        if (!$posta || $posta->type == 'quiz') {
            return "no";
        }

        $pids = explode('|', $pid);
        $idarays = array();
        foreach ($pids as $pi) {
            array_push($idarays, $pi);
        }

        $post = "";
        if (!empty($posta->tags)) {
            $tags = explode(',', $posta->tags);

            foreach ($tags as $key) {
                $posto = Post::approve('yes')->whereNotIn('id', $idarays)->where('tags', 'LIKE',  '%' . $key . '%')->activeTypes()->byPublished()->first();
                if ($posto) {
                    $post = $posto;
                }
            }
        }

        if (empty($post)) {
            $categories = explode(',', $posta->categories);

            foreach ($categories as $keya) {
                $posto = Post::approve('yes')->whereNotIn('id',  $idarays)->where('type', $type)->where('categories', 'LIKE',  '%' . $keya . '%')->activeTypes()->byPublished()->first();
                if ($posto) {
                    $post = $posto;
                }
            }
        }

        if (!$post) {
            return "no";
        }

        $entries = $post->entries();
        if ($post->pagination == null) {
            $entries =  $entries->where('type', '!=', 'answer')->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->get();
        } else {
            $entries =  $entries->where('type', '!=', 'answer')->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->paginate($post->pagination);
        }

        $reactions = false;
        if (get_buzzy_config('p_reactionform') == 'on') {
            $reactions = $post->reactions;
        }

        $publish_from_now = '';

        return view("pages.postloadpage", compact("post", 'entries', 'reactions', 'publish_from_now'));
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function commentload(Request $request)
    {
        $id = $request->query('id');
        $url = $request->query('url');

        return view('_forms._commentforms', compact('id', 'url'));
    }

    public function postHit($post)
    {
        if (null == Cookie::get('BuzzyPostHit' . $post->id)) {
            $post->hit();
            Cookie::queue('BuzzyPostHit' . $post->id, "1", 10, generate_post_url($post));
        }
    }
}
