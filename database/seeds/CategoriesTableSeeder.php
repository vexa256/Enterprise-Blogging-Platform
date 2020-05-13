<?php

use Illuminate\Database\Seeder;



class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'order' => '1',
            'name' => 'News',
            'name_slug' => 'news',
            'posturl_slug' => 'news',
            'icon' => '<i class=material-icons>library_books</i>',
            'description' => 'News enables you to share the latest breaking news content on the web.',
            'type' => 'news',
            'disabled' => '0',
            'main' => '1',
        ]);
        DB::table('categories')->insert([
            'order' => '2',
            'name' => 'Lists',
            'name_slug' => 'lists',
            'posturl_slug' => 'list',
            'icon' => '<i class=material-icons>&#xE1DB;</i>',
            'description' => 'Create most interesting viral lists on your site and share with all your friends.',
            'type' => 'list',
            'disabled' => '0',
            'main' => '1',
        ]);
        DB::table('categories')->insert([
            'order' => '3',
            'name' => 'Quizzes',
            'name_slug' => 'quizzes',
            'posturl_slug' => 'quiz',
            'icon' => '<i class=material-icons>&#xE834;</i>',
            'description' => 'Get start to make great viral quizzes with Buzzy Quizzes Plugin TODAY!',
            'type' => 'quiz',
            'disabled' => '0',
            'main' => '1',
        ]);
        DB::table('categories')->insert([
            'order' => '4',
            'name' => 'Polls',
            'name_slug' => 'polls',
            'posturl_slug' => 'poll',
            'icon' => '<i class=material-icons>&#xE837;</i>',
            'description' => 'Polls are awesome! Share all questions in your mind! Learn the other people thoughts.',
            'type' => 'poll',
            'disabled' => '0',
            'main' => '1',
        ]);
        DB::table('categories')->insert([
            'order' => '5',
            'name' => 'Videos',
            'name_slug' => 'videos',
            'posturl_slug' => 'video',
            'icon' => '<i class=material-icons>&#xE038;</i>',
            'description' => 'Share post popular, funny videos.',
            'type' => 'video',
            'disabled' => '0',
            'main' => '1',
        ]);

        DB::table('categories')->insert([
            'order' => '0',
            'name' => 'Inbox',
            'name_slug' => 'inbox',
            'posturl_slug' => 'inbox',
            'icon' => 'inbox',
            'description' => '',
            'type' => 'mailcat',
            'disabled' => '0',
            'main' => '0',
        ]);
        DB::table('categories')->insert([
            'order' => '0',
            'name' => 'Sent',
            'name_slug' => 'sent',
            'posturl_slug' => 'sent',
            'icon' => 'envelope-o',
            'description' => '',
            'type' => 'mailcat',
            'disabled' => '0',
            'main' => '0',
        ]);
        DB::table('categories')->insert([
            'order' => '0',
            'name' => 'Drafts',
            'name_slug' => 'drafts',
            'posturl_slug' => 'drafts',
            'icon' => 'file-text-o',
            'description' => '',
            'type' => 'mailcat',
            'disabled' => '0',
            'main' => '0',
        ]);
        DB::table('categories')->insert([
            'order' => '0',
            'name' => 'Junk',
            'name_slug' => 'junk',
            'posturl_slug' => 'junk',
            'icon' => 'filter',
            'description' => '',
            'type' => 'mailcat',
            'disabled' => '0',
            'main' => '0',
        ]);
        DB::table('categories')->insert([
            'order' => '0',
            'name' => 'Trash',
            'name_slug' => 'trash',
            'posturl_slug' => 'trash',
            'icon' => 'trash-o',
            'description' => '',
            'type' => 'mailcat',
            'disabled' => '0',
            'main' => '0',
        ]);
        DB::table('categories')->insert([
            'order' => '',
            'name' => 'Advertisement',
            'name_slug' => 'advertisement',
            'posturl_slug' => '',
            'icon' => '',
            'description' => '#B77528',
            'type' => 'maillabel',
            'disabled' => '0',
            'main' => '0',
        ]);

        DB::table('categories')->insert([
            'order' => '',
            'name' => 'Other',
            'name_slug' => 'other',
            'posturl_slug' => '',
            'icon' => '',
            'description' => '#B22D5B',
            'type' => 'maillabel',
            'disabled' => '0',
            'main' => '0',
        ]);

    }
}
