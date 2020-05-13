<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\Entry;
use Carbon\Carbon;
use App\Categories;
use App\Http\UploadManager;
use Illuminate\Http\Request;

class PostEditorController extends Controller
{
    private $delete_images = [];

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->middleware('DemoAdmin', ['only' => ['deletePost', 'editPost']]);
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function showPostCreate(Request $request)
    {
        $this->authorize('create', Post::class);

        $post_type = $request->query('new');

        if (!$post_type) {
            $post_type = "news";
        }

        if (!array_key_exists($post_type, get_post_types())) {
            \Session::flash('success.message', trans('v3.notvalidposttype'));
            return redirect('/');
        }

        return view("posts.newCreate", compact("post_type"));
    }

    public function showPostEdit(Request $request, $post_id)
    {
        $post = Post::findOrFail($post_id);

        $this->authorize('update', $post);

        if ($post->ordertype == "trivia" and $request->query('qtype') !== 'trivia') {
            return redirect(action('PostEditorController@showPostEdit', [$post->id]) . '?qtype=trivia');
        }

        $entries = $post->entries()->where('type', '!=', 'answer')->oldest("order")->get();

        $post_type = $post->type;

        $entriesquizquest = "";
        $entriesquizresults = "";
        $entriesquizresultsseletc = "";

        if ($post_type == 'quiz') {
            $entriesquizquest = $post->entries()->where('type', 'quizquestion')->oldest("order")->get();
            $entriesquizresults = $post->entries()->byType("quizresult")->oldest("order")->get();
        }

        return view(
            "posts.editCreate",
            compact(
                "post_type",
                "post",
                "entries",
                "entriesquizquest",
                "entriesquizresults"
            )
        );
    }

    /**
     * Delete posts but not permanently
     *
     * @return \Illuminate\View\View
     */

    public function deletePost($post_id)
    {
        $post = Post::findOrFail($post_id);

        $this->authorize('delete', $post);

        // @TODO do we need that?
        $post->approve = 'no';
        $post->delete();

        \Session::flash('success.message', trans('updates.movedtotrash'));

        return redirect('/');
    }

    /**
     * Adding new post element
     *
     * @return \Illuminate\View\View
     */
    public function createPost(Request $request)
    {
        try {
            $this->authorize('create', Post::class);

            $validator = $this->getPostValidator($request);

            if ($validator !== 'passed') {
                return $validator;
            }

            $post = new Post;

            return $this->savePost($request->all(), $post);
        } catch (\Exception $e) {
            return $this->response(trans('updates.error'), $e->getMessage());
        }
    }

    /**
     * Adding new post element
     *
     * @return \Illuminate\View\View
     */
    public function editPost(Request $request, $post_id)
    {
        try {
            $post = Post::findOrFail($post_id);

            $this->authorize('update', $post);

            $validator = $this->getPostValidator($request, $post->id);

            if ($validator !== 'passed') {
                return $validator;
            }

            return $this->savePost($request->all(), $post, true);
        } catch (\Exception $e) {
            return $this->response(trans('updates.error'), $e->getMessage());
        }
    }

    /**
     * Adding new post element
     *
     * @return \Illuminate\View\View
     */
    private function savePost($inputs, $post, $update = false)
    {
        try {
            $post_slug = $this->createPostSlug($inputs['slug'], $inputs['title']);

            if ($update) {
                if (makepreview($post->thumb, 'b', 'posts') != $inputs['thumb']) {
                    $post_thumb = $this->movePostImage($inputs['thumb'], $post_slug, $post->thumb);

                    if (is_array($post_thumb)) {
                        return $post_thumb;
                    }

                    $post->thumb = $post_thumb;
                }
            } else {
                $post_thumb = $this->movePostImage($inputs['thumb'], $post_slug);

                if (is_array($post_thumb)) {
                    return $post_thumb;
                }

                $post->thumb = $post_thumb;
            }

            $post->slug = isset($inputs['slug']) ? $inputs['slug'] : $post_slug;
            $post->title = $inputs['title'];
            $post->body = $inputs['description'];
            $post->category_id = parse_main_category($inputs['category']);
            $post->categories = json_encode($inputs['category']);
            $post->type = $inputs['type'];
            $post->tags = isset($inputs['tags']) ? $inputs['tags'] : '';
            $post->ordertype = isset($inputs['ordertype']) && $inputs['ordertype'] !== 'none' ? $inputs['ordertype'] : null;
            $post->pagination = isset($inputs['pagination']) && $inputs['pagination'] != 0 ? $inputs['pagination'] : null;
            $post->published_at = isset($inputs['published_at']) ? $inputs['published_at'] : Carbon::now();

            $auto_approve = $update ? 'AutoEdited' : 'AutoApprove';
            if ($inputs['post_status'] == 'draft') {
                $post->approve = 'draft';
            } elseif (
                get_buzzy_config($auto_approve) == 'yes'
                || Auth::user()->usertype == 'Staff'
                || Auth::user()->usertype == 'Admin' && Auth::user()->email !== 'demo@admin.com'
            ) {
                $post->approve = 'yes';
            } else {
                $post->approve = 'no';
            }

            if ($update) {
                $post->save();
                $this->deleteRemovedEntries($inputs['entries'], $post);
            } else {
                $post->user_id = Auth::user()->id;
                $post->save();
                //  $post->user_id = Auth::user()->id;
                //$post->create();
                //Auth::user()->posts()->create($post);
            }

            $this->createEntries($inputs['entries'], $post->id);

            $this->removeTmpFiles();

            if ($update) {
                $message = $post->approve === 'no' ? trans('v3.successupdatedapprove') : trans('index.successupdated');
                \Session::flash('success.message', $message);
            } else {
                $message = $post->approve === 'no' ? trans('index.successcreated') : trans('v3.successcreatednotapprove');
                \Session::flash('success.message', $message);
            }

            return $this->response('', '', 'success', ['url' => generate_post_url($post)]);
        } catch (\Exception $e) {
            return $this->response(trans('updates.error'), $e->getMessage());
        }
    }

    private function removeTmpFiles()
    {
        // incase if $thumb then tuse save button. we need to save image for that
        try {
            $imageM = new UploadManager();

            foreach ($this->delete_images as $image) {
                $imageM->delete($image);
            }
        } catch (\Exception $e) {
            //
        }
    }

    private function checkIfEntryRemovedFromEntries($entries, $entry_id)
    {
        foreach ($entries as $entry) {
            if (isset($entry['id']) && $entry['id'] == $entry_id) {
                return true; // founded
            } elseif (isset($entry["answers"])) {
                foreach ($entry["answers"] as $answer) {
                    if (!empty($answer['id']) && $answer['id'] == $entry_id) {
                        return true; // founded as answer
                    }
                }
            }
        }

        return false;
    }

    private function deleteRemovedEntries($entries, $post)
    {
        foreach ($post->entries()->get() as $entry) {
            if (!$this->checkIfEntryRemovedFromEntries($entries, $entry->id)) {
                $entry->forceDelete();
            }
        }
    }

    private function createEntries($entries, $post_id)
    {
        foreach ((array) $entries as $entry_key => $_entry) {
            $entry_type = $_entry['type'];
            $entry_id = isset($_entry['id']) ? $_entry['id'] : null;

            if ($entry_id !== null && !empty($entry_id)) {
                $entry = Entry::find($entry_id);
                if (!$entry) {
                    continue; // no error just skip
                }

                $entry_image = $entry->image;
            } else {
                $entry = new Entry;
                $entry_image = null;
                $entry->user_id = Auth::user()->id;
            }

            $entry->post_id = $post_id;
            $entry->order = $entry_key;
            $entry->type = $entry_type;
            $entry->title = isset($_entry['title']) ? $_entry['title'] : null;
            $entry->body = isset($_entry['body']) ? $_entry['body'] : null;
            $entry->source = isset($_entry['source']) ? $_entry['source'] : null;

            if ($entry_type == "image" || $entry_type == "poll" || $entry_type == "quizquestion" || $entry_type == "quizresult") {
                if (makepreview($entry_image, null, 'entries') != $_entry['image']) {
                    $imgRR = $this->moveEntryImage($_entry['image'], $post_id, $entry_type, $entry_key, $entry_image);

                    if (is_array($imgRR)) {
                        return $imgRR;
                    }

                    $entry->image = $imgRR;
                }
            }

            if ($entry_type == "quizquestion" || $entry_type == "poll") {
                $entry->video = isset($_entry['listtype']) ? $_entry['listtype'] : 3;
            } else {
                $entry->video = isset($_entry['video']) ? $_entry['video'] : null;
            }

            $entry->save();

            //start answers
            if ($entry_type == "quizquestion" || $entry_type == "poll") {
                $this->createAnswers($_entry['answers'], $post_id, $entry->id, $entry->video);
            }
        }
    }

    private function createAnswers($answers, $post_id, $question_id, $listtype)
    {
        if ($answers) {
            foreach ($answers as $answer_key => $_answer) {
                $answer_id = isset($_answer['id']) ? $_answer['id'] : null;

                if ($answer_id !== null && !empty($answer_id)) {
                    $answer = Entry::find($answer_id);

                    if (!$answer) {
                        continue;
                    }

                    $answer_image = $answer->image;
                } else {
                    $answer = new Entry;
                    $answer->user_id = Auth::user()->id;
                    $answer_image = null;
                }

                $answer->post_id = $post_id;
                $answer->order = $answer_key;
                $answer->type = 'answer';
                $answer->title = isset($_answer['title']) ? $_answer['title'] : null;
                $answer->video = isset($_answer['assign']) ? $_answer['assign'] : null;
                $answer->source = $question_id;

                if ($listtype !== "3") {
                    if (makepreview($answer_image, null, 'answers') != $_answer['image']) {
                        $imgRR = $this->moveAnswerImage($_answer['image'], $post_id, $question_id, $answer_key, $answer_image);

                        if (is_array($imgRR)) {
                            return $imgRR;
                        } else {
                            $answer->image = $imgRR;
                        }
                    }
                }

                $answer->save();
            }
        }
    }

    private function movePostImage($thumb, $slug, $post_thumb = null)
    {
        if (empty($slug)) {
            $slug = md5($slug . time());
        }

        // incase if $thumb then tuse save button. we need to save image for that
        try {
            $result = null;  // empty image

            $image = new UploadManager();

            if ($thumb && null !== $thumb) {
                // user may use http url we cant just move image from tmp. regenerate image and remove tmp file if exist
                $image->path('upload/media/posts');
                $image->name($slug . '_' . time());
                $image->setUrlFile($thumb);
                $image->make();
                $image->mime('jpg');
                $image->save(
                    [
                        'fit_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_width'),
                        'fit_height' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_height'),
                        'image_size' => 'b',
                    ]
                ); // move big image
                $image->save(
                    [
                        'fit_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_small_width'),
                        'fit_height' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_small_height'),
                        'image_size' => 's',
                    ]
                );

                // add delete queue
                $this->delete_images[] = $thumb;

                $result = $image->getPathforSave();
            }

            // delete old saved file
            if ($post_thumb && null !== $post_thumb) {
                $this->delete_images[] = makepreview($post_thumb, 'b', 'posts');
                $this->delete_images[] = makepreview($post_thumb, 's', 'posts');
            }

            return $result;
        } catch (\Exception $e) {
            return $this->response(trans('updates.error'), trans('addpost.preview') . ' | ' . $e->getMessage());
        }
    }

    private function moveEntryImage($thumb, $post_id, $entry_type, $entry_order, $entry_thumb = null)
    {
        try {
            $result = null; // empty image

            $image = new UploadManager();

            if ($thumb && null !== $thumb) {
                $image->path('upload/media/entries');
                $image->name($post_id . '-entry-' . $entry_order . '-' . time());
                $image->setUrlFile($thumb);
                $image->make();
                $image->mime('jpg');
                $image->acceptGif();
                $image->save(
                    [
                        'resize_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.entry-image_big_width'),
                    ]
                );

                // add delete queue
                $this->delete_images[] = $thumb;

                $result = $image->getPathforSaveWithMime();
            }

            // delete old saved file
            if ($entry_thumb && null !== $entry_thumb) {
                $this->delete_images[] = makepreview($entry_thumb, null, 'entries');
            }

            return $result;
        } catch (\Exception $e) {
            if ($entry_type == "quizresult") {
                return $this->response(trans('buzzyquiz.quizresulterror'), trans('buzzyquiz.quizresulterrors', ['numberofentry' => $entry_order + 1, 'error' => $e->getMessage()]));
            } elseif ($entry_type == "quizquestion") {
                return $this->response(trans('buzzyquiz.questionerror'), trans('buzzyquiz.questionerrors', ['numberofentry' => $entry_order + 1, 'error' => $e->getMessage()]));
            } elseif ($entry_type == "poll") {
                return $this->response(trans('buzzyquiz.questionerror'), trans('buzzyquiz.questionerrors', ['numberofentry' => $entry_order + 1, 'error' => $e->getMessage()]));
            } else {
                return $this->response(trans('updates.error'), trans('updates.entryerrors', ['numberofentry' => $entry_order + 1, 'error' => $e->getMessage()]));
            }
        }
    }

    private function moveAnswerImage($thumb, $postid, $entryorder, $answerorder, $entry_thumb = null)
    {
        try {
            $result = null; // empty image

            $image = new UploadManager();

            if ($thumb && null !== $thumb) {
                $image->path('upload/media/answers');
                $image->name($postid . '-question-' . $entryorder . '-answer-' . $answerorder . '-' . time());
                $image->setUrlFile($thumb);
                $image->make();
                $image->mime('jpg');
                $image->save(
                    [
                        'fit_width' => 250,
                        'fit_height' => 250,
                    ]
                );

                // add delete queue
                $this->delete_images[] = $thumb;

                $result = $image->getPathforSaveWithMime();
            }

            // delete old saved file
            if ($entry_thumb && null !== $entry_thumb) {
                $this->delete_images[] = makepreview($entry_thumb, null, 'answers');
            }

            return $result;
        } catch (\Exception $e) {
            return $this->response(trans('updates.error'), trans('buzzyquiz.answererrors', ['numberofentry' => $entryorder + 1, 'numberofanswer' => $answerorder + 1, 'error' => $e->getMessage()]));
        }
    }

    /**
     * Validator of question posts
     *
     * @param  $inputs
     * @return array|bool
     */
    protected function Postvalidator(array $inputs, $post_id = null)
    {
        $rules = [
            'type' => 'required',
            'title' => 'required|min:5|max:255|unique:posts',
            'slug' => 'required|min:5|max:255|unique:posts',
            'category' => 'required',
            'pagination' => 'nullable|max:2',
            'description'  => 'required|min:4|max:500',
            'tags'  => 'nullable|max:2500',
            'thumb' => 'required|min:10',
            'post_status' => 'required',
            'published_at' => 'nullable|date'
        ];

        if ($post_id !== null) {
            $rules = array_merge(
                $rules,
                [
                    'title' => 'required|min:5|max:255|unique:posts,title,' . $post_id,
                    'slug' => 'required|min:5|max:255|unique:posts,slug,' . $post_id,
                ]
            );
        }

        return \Validator::make($inputs, $rules);
    }

    /**
     * Validator of question posts
     *
     * @param  $inputs
     * @return array|bool
     */
    protected function EntryValidator(array $inputs, $entry_type)
    {
        $rules = [];
        if ($entry_type == "text") {
            $rules = ['type' => 'required', 'title' => 'nullable|min:1|max:255', 'body' => 'required', 'source' => ''];
        } elseif ($entry_type == "image") {
            $rules = ['type' => 'required', 'title' => 'nullable|min:1|max:255', 'body' => '', 'source' => '', 'image' => 'required'];
        } elseif ($entry_type == "video") {
            $rules = ['type' => 'required', 'title' => 'nullable|min:1|max:255', 'body' => '', 'source' => 'nullable', 'video' => 'required|max:500'];
        } elseif ($entry_type == "embed" || $entry_type == "tweet"  || $entry_type == "facebookpost" || $entry_type == "instagram" || $entry_type == "soundcloud") {
            $rules = ['type' => 'required', 'title' => 'nullable|max:255', 'body' => '', 'source' => '', 'video' => 'required|max:1000'];
        } elseif ($entry_type == "quizresult") {
            $rules = ['type' => 'required', 'title' => 'required|min:2|max:255', 'body' => 'required|min:5|max:500', 'image' => ''];
        } elseif ($entry_type == "quizquestion") {
            $rules = ['type' => 'required', 'title' => 'nullable|min:2|max:255', 'body' => 'nullable|max:500', 'image' => '', 'listtype' => 'required'];
        } elseif ($entry_type == "poll") {
            $rules = ['type' => 'required', 'title' => 'nullable|max:255', 'body' => 'nullable|max:500', 'image' => '', 'listtype' => 'required'];
        }

        return \Validator::make($inputs, $rules);
    }

    /**
     * Validator of question posts
     *
     * @param  $inputs
     * @return array|bool
     */
    protected function QuizAnswerValidator(array $inputs, $listtype)
    {

        if ($listtype == "1" || $listtype == "2") {
            $rules = ['type' => 'required', 'title' => 'nullable|max:45', 'image' => 'required', 'assign' => 'required'];
        } elseif ($listtype == "3") {
            $rules = ['type' => 'required', 'title' => 'required|min:2|max:250', 'image' => '', 'assign' => 'required'];
        }

        return \Validator::make($inputs, $rules);
    }

    protected function getPostValidator($request, $post_id = null)
    {
        $inputs = $request->all();

        $v = $this->Postvalidator($request->only('title', 'slug', 'description', 'category', 'tags', 'pagination', 'type', 'thumb', 'post_status', 'published_at', '_token'), $post_id);

        if ($v->fails()) {
            return $this->response(trans('updates.error'), $v->errors()->first());
        }

        //quiz validators
        if ($inputs['type'] == "quiz") {
            $quizresultcount = 0;
            foreach ($inputs['entries'] as $value) {
                if ($value['type'] == 'quizresult') {
                    $quizresultcount++;
                }
            }

            if ($quizresultcount < 2 and $inputs['ordertype'] !== 'trivia') {
                return $this->response(trans('buzzyquiz.quizerror'), trans('buzzyquiz.atlest2result'));
            }

            $quizquestioncount = 0;
            foreach ($inputs['entries'] as $valueq) {
                if ($valueq['type'] == 'quizquestion') {
                    $quizquestioncount++;
                }
            }

            if ($quizquestioncount < 1) {
                return $this->response(trans('buzzyquiz.quizerror'), trans('buzzyquiz.atlest1question'));
            }
        }


        foreach ($inputs['entries'] as $key => $entry) {
            $entry_type = $entry['type'];


            $v = $this->EntryValidator($entry, $entry_type);

            if ($v->fails()) {
                $keya = $key + 1;

                if ($entry_type == "quizresult") {
                    return $this->response(trans('buzzyquiz.quizresulterror'), trans('buzzyquiz.quizresulterrors', ['numberofentry' => $keya, 'error' => $v->errors()->first()]));
                } elseif ($entry_type == "quizquestion") {
                    return $this->response(trans('buzzyquiz.questionerror'), trans('buzzyquiz.questionerrors', ['numberofentry' => $keya - $quizresultcount, 'error' => $v->errors()->first()]));
                } elseif ($entry_type == "poll") {
                    return $this->response(trans('buzzyquiz.questionerror'), trans('buzzyquiz.questionerrors', ['numberofentry' => $keya, 'error' => $v->errors()->first()]));
                } else {
                    return $this->response(trans('updates.error'), trans('updates.entryerrors', ['numberofentry' => $keya, 'error' => $v->errors()->first()]));
                }
            } else {
                if ($entry_type == "poll") {
                    $quizresultcount = 0;
                }

                if ($entry_type == "quizquestion" || $entry_type == "poll") {
                    if (!isset($entry['answers']) || count($entry['answers']) < 2) {
                        return $this->response(trans('buzzyquiz.questionerror'), trans('buzzyquiz.questionerrors', ['numberofentry' => $key - $quizresultcount + 1, 'error' => trans('buzzyquiz.atlest2answer')]));
                    }

                    foreach ($entry['answers'] as $ankey => $ann) {
                        $qv = $this->QuizAnswerValidator($ann, $entry['listtype']);

                        if ($qv->fails()) {
                            $keyaa = $ankey + 1;
                            return $this->response(trans('buzzyquiz.answererror'), trans('buzzyquiz.answererrors', ['numberofentry' => $key - $quizresultcount + 1, 'numberofanswer' => $keyaa, 'error' => $qv->errors()->first()]));
                        }
                    }
                }
            }
        }

        return 'passed';
    }

    private function response($title = '', $message = '', $status = 'error', $extra = [])
    {
        return array_merge(['status' => $status, 'title' => $title, 'message' => $message], $extra);
    }

    private function createPostSlug($slug, $title)
    {
        if (!empty($slug)) {
            $slug = sanitize_title_with_dashes($slug);
        } else {
            $slug = sanitize_title_with_dashes($title);
        }

        if (empty($slug)) {
            $slug = preg_replace("/[\s-]+/", " ", $title);

            // Convert whitespaces and underscore to the given separator
            $slug = preg_replace("/[\s_]/", '-', $slug);
        }

        return $slug;
    }
}
