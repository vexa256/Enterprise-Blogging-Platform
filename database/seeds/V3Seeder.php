<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

class V3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // set 2.5.0 for older versions we don't have BUZZY_VERSION variable
        if (version_compare(env('BUZZY_VERSION', '0.0.0'), '3.0.0', '>=')) return;

        if (file_exists(public_path('assets/img/logo.png'))) {
            copy(public_path('assets/img/logo.png'), public_path('assets/images/logo.png'));
        }
        if (file_exists(public_path('assets/img/flogo.png'))) {
            copy(public_path('assets/img/flogo.png'), public_path('assets/images/flogo.png'));
        }
        if (file_exists(public_path('assets/img/favicon.png'))) {
            copy(public_path('assets/img/favicon.png'), public_path('assets/images/favicon.png'));
        }

        // set without Conf
        set_buzzy_config('MAIL_DRIVER', get_buzzy_config('MAIL_DRIVER'), false);
        set_buzzy_config('MAIL_HOST', get_buzzy_config('MAIL_HOST'), false);
        set_buzzy_config('MAIL_PORT', get_buzzy_config('MAIL_PORT'), false);
        set_buzzy_config('MAIL_USERNAME', get_buzzy_config('MAIL_USERNAME'), false);
        set_buzzy_config('MAIL_PASSWORD', get_buzzy_config('MAIL_PASSWORD'), false);
        set_buzzy_config('MAIL_ENCRYPTION', get_buzzy_config('MAIL_ENCRYPTION'), false);

        set_buzzy_config('p_buzzynews', get_buzzy_config('p-buzzynews'));
        set_buzzy_config('p_buzzylists', get_buzzy_config('p-buzzylists'));
        set_buzzy_config('p_buzzypolls', get_buzzy_config('p-buzzypolls'));
        set_buzzy_config('p_buzzyquizzes', get_buzzy_config('p-buzzyquizzes'));
        set_buzzy_config('p_buzzycontact', get_buzzy_config('p-buzzycontact'));
        set_buzzy_config('p_buzzyvideos', get_buzzy_config('p-buzzyvideos'));
        set_buzzy_config('p_facebookcomments', get_buzzy_config('p-facebookcomments'));
        set_buzzy_config('p_disquscomments', get_buzzy_config('p-disquscomments'));
        set_buzzy_config('p_reactionform', get_buzzy_config('p-reactionform'));
        set_buzzy_config('p_homepagebuilder', get_buzzy_config('p-homepagebuilder'));

        //delete old config
        set_buzzy_config('MAIL_DRIVER', '');
        set_buzzy_config('MAIL_HOST', '');
        set_buzzy_config('MAIL_PORT', '');
        set_buzzy_config('MAIL_USERNAME', '');
        set_buzzy_config('MAIL_PASSWORD', '');
        set_buzzy_config('MAIL_ENCRYPTION', '');
        set_buzzy_config('p-buzzynews', '');
        set_buzzy_config('p-buzzylists', '');
        set_buzzy_config('p-buzzypolls', '');
        set_buzzy_config('p-buzzyquizzes', '');
        set_buzzy_config('p-buzzycontact', '');
        set_buzzy_config('p-buzzyvideos', '');
        set_buzzy_config('p-facebookcomments', '');
        set_buzzy_config('p-disquscomments', '');
        set_buzzy_config('p-reactionform', '');
        set_buzzy_config('p-homepagebuilder', '');


        DB::table('categories')->whereIn('main', ["1", "2"])->update([
            'main' => '1', // set all main categories as "1" now
        ]);

        // subs main should 2
        DB::table('categories')->whereNotIn('type', ['mailcat', 'maillabel', 'mailprivatecat'])->whereNotIn('main', ['1'])->update([
            'main' => '2', // set all sub categories as "2" now
        ]);


        DB::table('reactions_icons')->orderBy('id')->chunk(100, function ($icons) {
            foreach ($icons as $icon) {
                DB::table('reactions_icons')
                    ->where('id', $icon->id)
                    ->update(['icon' => str_replace('assets/img', 'assets/images', $icon->icon)]);
            }
        });

        DB::table('popularity_stats')->where('trackable_type', 'App\Posts')
            ->update(['trackable_type' => 'App\Post']);

        if (file_exists(storage_path('.buzzy'))) {
            $new_file = '.' . config('buzzy.item_id');
            @rename(storage_path('.buzzy'), storage_path($new_file));
            @file_put_contents(storage_path($new_file), str_replace('-bundle-buzzy', '', file_get_contents(storage_path($new_file))));
            set_buzzy_config('APP_INSTALLED', 'true', false);
        }
        if (file_exists(storage_path('.buzzyquizzes'))) {
            $new_file = '.' . config('buzzyquizzes.item_id');
            @rename(storage_path('.buzzyquizzes'), storage_path($new_file));
            @file_put_contents(storage_path($new_file), str_replace('-bundle-quizzes', '', file_get_contents(storage_path($new_file))));
            set_buzzy_config('buzzyquizzes_INSTALLED', 'true', false);
        }
        if (file_exists(storage_path('.buzzycontact'))) {
            $new_file = '.' . config('buzzycontact.item_id');
            @rename(storage_path('.buzzycontact'), storage_path($new_file));
            @file_put_contents(storage_path($new_file), str_replace('-bundle-buzzycontact', '', file_get_contents(storage_path($new_file))));
            set_buzzy_config('buzzycontact_INSTALLED', 'true', false);
        }
        if (file_exists(storage_path('.easycomment'))) {
            $new_file = '.' . config('easycomment.item_id');
            @rename(storage_path('.easycomment'), storage_path($new_file));
            @file_put_contents(storage_path($new_file), str_replace('-bundle-easycomment', '', file_get_contents(storage_path($new_file))));
            set_buzzy_config('easycomment_INSTALLED', 'true', false);
        }
    }
}
