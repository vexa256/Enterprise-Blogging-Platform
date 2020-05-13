<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('installer')->namespace('Installer')->name('installer.')->group(
    function () {
        Route::get('welcome', 'HomeController@index');
        Route::get('permissions', 'PermissionsController@index');
        Route::get('database', 'DatabaseController@index');
        Route::post('database', 'DatabaseController@post');
        Route::get('finish', 'DatabaseController@finish');

        Route::get('update', 'UpdateController@update');
        Route::get('update_init',  'UpdateController@update_init');
    }
);

// Admin
Route::middleware('Admin')->namespace('Admin')->prefix('admin')->group(
    function () {

        Route::get('/', 'DashboardController@index');
        Route::get('/reports/{type}', 'ReportsController@index');

        Route::post('/handle-download', 'UpdateController@handle');

        Route::get('plugins', 'PluginsController@show');
        Route::post('activate-plugin', 'PluginsController@handleActivation');

        Route::get('themes/{theme}', 'ThemesController@settings');
        Route::get('themes', 'ThemesController@show');
        Route::post('activate-theme', 'ThemesController@handleActivation');

        Route::post('add-new-category', 'CategoriesController@addnew');
        Route::get('categories/delete/{id}', 'CategoriesController@delete');
        Route::get('categories', 'CategoriesController@index');
        Route::get('config', 'ConfigController@index');
        Route::post('config', 'ConfigController@setconfig');

        Route::get('/tools', 'ToolsController@index');
        Route::get('/removeTmpFolder', 'ToolsController@removeTmpFolder');

        Route::get('post-approve/{id}', 'PostsController@approvePost');
        Route::get('post-send-to-trash/{id}', 'PostsController@deletePost');
        Route::get('post-delete-perma/{id}', 'PostsController@forceDeletePost');
        Route::get('post-set-for-homepage/{id}', 'PostsController@setForHomepage');
        Route::get('post-set-featured/{id}', 'PostsController@setFeatured');

        Route::get('features', 'PostsController@features');
        Route::get('unapprove', 'PostsController@unapprove');
        Route::get('all', 'PostsController@all');
        Route::get('/cat/{name}', 'PostsController@showcatposts');
        Route::get('postlist', 'PostsController@getdata');

        Route::get('users', 'UsersController@users');
        Route::get('userlist', 'UsersController@getdata');

        Route::post('pages/addnew', 'PagesController@addnew');

        Route::get('pages/edit/{id}', 'PagesController@edit');
        Route::get('pages/delete/{id}', 'PagesController@delete');
        Route::get('pages/add', 'PagesController@add');
        Route::get('pages', 'PagesController@index');


        Route::post('widgets/addwidget', 'WidgetsController@addnew');
        Route::get('widgets/delete/{id}', 'WidgetsController@delete');
        Route::get('widgets', 'WidgetsController@index');

        Route::post('reactions/addnew', 'ReactionController@addnew');
        Route::get('reactions/delete/{id}', 'ReactionController@delete');
        Route::get('reactions', 'ReactionController@index');

        Route::prefix('mailbox')->group(
            function () {
                Route::post('getmails', 'ContactController@getdata');
                Route::post('newmailsent', 'ContactController@newmailsent');
                Route::post('doaction', 'ContactController@doaction');
                Route::post('dostar', 'ContactController@dostar');
                Route::post('doimportant', 'ContactController@doimportant');
                Route::post('addcat', 'ContactController@addcat');

                Route::get('new', 'ContactController@newmail');
                Route::get('mailcatdelete/{id}', 'ContactController@mailcatdelete');
                Route::get('maillabeldelete/{id}', 'ContactController@maillabeldelete');
                Route::get('read/{id}', 'ContactController@read');
                Route::get('/{type?}', 'ContactController@index');
                Route::get('/', 'ContactController@index');
            }
        );
    }
);



// Home
Route::get('/', 'IndexController@index');
Route::get('404', 'PagesController@dort');

// Misc
Route::get('{type}.xml', 'RssController@index');
Route::get('fbinstant.rss', 'RssController@fbinstant');
Route::get('{type}.json', 'RssController@json');
Route::get('/selectlanguge/{locale}', 'IndexController@changeLanguage');

// Docs - Delete this in production
Route::get('admin/docs', 'Admin\DocsController@show');

// Api
Route::post('register_product', 'Api\ActivationController@handle');


// Auth
Route::get('auth/social/{type}', 'Auth\SocialAuthController@socialConnect');
Route::get('auth/social/{type}/callback', 'Auth\SocialAuthController@socialCallback');
Auth::routes();

// Contact
Route::get('contact', 'ContactController@index');
Route::post('contact', 'ContactController@create');

// Amp
Route::get('amp/{catname}/{slug}', 'PostsController@amp');
Route::get('amp', 'IndexController@amp');

// User Profile
Route::post('profile/{userslug}/settings', 'UsersController@updatesettings');
Route::post('profile/{userslug}/follow', 'UsersController@follow');
Route::get('profile/{userslug}/settings', 'UsersController@settings');
Route::get('profile/{userslug}/following', 'UsersController@following');
Route::get('profile/{userslug}/followers', 'UsersController@followers');
Route::get('profile/{userslug}/feed', 'UsersController@followfeed');
Route::get('profile/{userslug}/draft', 'UsersController@draftposts');
Route::get('profile/{userslug}/trash', 'UsersController@deletedposts');
Route::get('profile/{userslug}', 'UsersController@index');

// Frontend Posting
Route::post('upload-a-image',  'UploadController@newUpload')->name('upload_image_request');
Route::post('fetch-video',  'FormController@fetchVideoEmbed')->name('fetch_video_request');
Route::get('addnewform',  'FormController@addnewform');
Route::post('create-post',  'PostEditorController@createPost');
Route::post('edit/{post_id}',  'PostEditorController@editPost');
Route::get('create',  'PostEditorController@showPostCreate');
Route::get('edit/{post_id}',  'PostEditorController@showPostEdit');
Route::get('delete/{post_id}',  'PostEditorController@deletePost');


Route::get('get_content_data',  'FormController@get_content_data');
Route::get('search',  'PagesController@search');
Route::post('shared', 'PollController@Shared');
Route::get('commentload',  'PostsController@commentload');
Route::get('reactions/{reaction}',  'PagesController@showReaction');

// Tax
Route::get('tag/{tag}',  'PagesController@showtag');

// Pages
Route::get('pages/{page}',  'PagesController@showpage');

// Posts
Route::get('ajax_previous',  'PostsController@ajax_previous');
Route::post('{catname}/{postname}/newvote', 'PollController@VoteANewPoll');
Route::post('{catname}/{postname}/vote', 'PollController@VoteAPoll');
Route::post('{catname}/{postname}/reaction', 'PollController@VoteReaction');
Route::get('{catname}/{slug}', 'PostsController@index');

// Search Category
Route::get('{catname}', 'PagesController@showCategory')->where('all', '.*');
