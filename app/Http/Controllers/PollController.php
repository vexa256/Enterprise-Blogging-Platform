<?php

namespace App\Http\Controllers;

use App\Entry;
use App\PollVotes;
use App\Post;
use App\Reactions;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PollController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (get_buzzy_config('sitevoting') == "1") {
            $this->middleware('auth');
        }
    }


    public function VoteANewPoll($entryid, $slug, Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $post = Post::where('slug', $slug)->first();
        $entry = Entry::where('id', $entryid)->first();

        $voteid = $request->query('vote');

        if (Auth::check()) {
            $auser = Auth::user()->id;
        } else {
            $auser = $request->ip();
        }

        $vote = new PollVotes;
        $vote->post_id = $entry->id;
        $vote->option_id = $voteid;
        $vote->user_id = $auser;
        $vote->save();

        if ($request->ajax()) {
            return view('_particles.lists.polllistanswers', compact("post", "entry"));
        }


        return true;
    }

    public function VoteAPoll($catname, $slug, Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $post = Post::where('type', $catname)->where('slug', $slug)->first();

        $entries = $post->entry;

        $voteid = $request->query('vote');

        if (Auth::check()) {
            $auser = Auth::user()->id;
        } else {
            $auser = $request->ip();
        }

        $vote = new PollVotes;
        $vote->post_id = $post->id;
        $vote->option_id = $voteid;
        $vote->user_id = $auser;
        $vote->save();


        if ($request->ajax()) {
            return view('_particles.lists.entrieslists', compact("post", "entries"));
        }


        return true;
    }
    public function VoteReaction($catname, $slug, Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $post = Post::where('slug', $slug)->first();

        $voteid = $request->query('reaction');

        if (Auth::check()) {
            $auser = Auth::user()->id;
        } else {
            $auser = $request->ip();
        }

        if (Reactions::currentUserHasVoteOnPost($post->id)->count() <= 2) {
            $reactions = new Reactions;
            $reactions->post_id = $post->id;
            $reactions->reaction_type = $voteid;
            $reactions->user_id = $auser;
            $reactions->save();

            $reactions = $post->reactions;

            if ($request->ajax()) {
                return view('_forms._reactionforms', compact("reactions", "post"));
            }
        };


        return true;
    }

    public function shared(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $inputs = $request->all();

        $id = $inputs['contentId'];
        $shareType = $inputs['shareType'];
        $post = Post::findOrFail($id);

        if (!isset($shareType)) {
            $shareType = 'facebook';
        }


        if (null ==  Cookie::get('BuzzyPosthared' . $shareType . $post->id)) {
            cookie('BuzzyPosthared' . $shareType . $post->id, $post->id, 15000, generate_post_url($post));
        } else {
            return "ok";
        }

        $pshared = [];
        $oshared = $post->shared;

        if (isset($post->shared->facebook)) {
            $pshared['facebook'] = $shareType == 'facebook' ? $oshared->facebook + 1 : $oshared->facebook;
        } else {
            $pshared['facebook'] = $shareType == 'facebook' ?  1 : 0;
        }

        if (isset($post->shared->twitter)) {
            $pshared['twitter'] =  $shareType == 'twitter' ? $oshared->twitter + 1 : $oshared->twitter;
        } else {
            $pshared['twitter'] = $shareType == 'twitter' ?  1 : 0;
        }

        if (isset($post->shared->gplus)) {
            $pshared['gplus'] = $shareType == 'gplus' ? $oshared->gplus + 1 : $oshared->gplus;
        } else {
            $pshared['gplus'] = $shareType == 'gplus' ?  1 : 0;
        }

        if (isset($post->shared->mail)) {
            $pshared['mail'] = $shareType == 'mail' ? $oshared->mail + 1 : $oshared->mail;
        } else {
            $pshared['mail'] = $shareType == 'mail' ?  1 : 0;
        }

        if (isset($post->shared->whatsapp)) {
            $pshared['whatsapp'] = $shareType == 'whatsapp' ? $oshared->whatsapp + 1 : $oshared->whatsapp;
        } else {
            $pshared['whatsapp'] = $shareType == 'whatsapp' ?  1 : 0;
        }

        $post->shared = json_encode($pshared);
        $post->save();

        return "ok";
    }
}
