<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Contacts;
use App\Categories;
use App\Http\Controllers\Api\AkProductApi;
use App\Http\Controllers\Controller;

class MainAdminController extends Controller
{
   /**
     * Update API.
     *
     * @var AkApi
     */
    public $product_api;

    public function __construct()
    {
        parent::__construct();

        $unapprovenews = Post::approve('no')->byType('news')->count();

        $unapprovelists = Post::approve('no')->byType('list')->count();

        $unapprovequizzes = Post::approve('no')->byType('quiz')->count();

        $unapprovepolls = Post::approve('no')->byType('poll')->count();

        $unapprovevideos = Post::approve('no')->byType('video')->count();

        $waitapprove = Post::approve('no')->take(15)->get();

        $cat = Categories::byType('mailcat')->where('name_slug', 'inbox')->first();

        if ($cat) {
            $unapproveinbox = Contacts::where('category_id', $cat->id)->where('read', 0)->count();
        } else {
            $unapproveinbox = 0;
        }

        $this->product_api = app(AkProductApi::class);
        $updates = $this->product_api->getUpdates();
 
        \View::share(
            [
            'waitapprove' => $waitapprove,
            'toplamapprove' => $unapprovenews + $unapprovelists + $unapprovepolls + $unapprovevideos,
            'napprovenews' => $unapprovenews,
            'napprovelists' => $unapprovelists,
            'unapprovequizzes' => $unapprovequizzes,
            'napprovepolls' => $unapprovepolls,
            'napprovevideos' => $unapprovevideos,
            'unapproveinbox' => $unapproveinbox,
            'updates' => $updates
            ]
        );
    }
}
