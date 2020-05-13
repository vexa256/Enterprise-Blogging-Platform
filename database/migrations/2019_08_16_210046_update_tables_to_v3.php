<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablesToV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('entries')) {
            Schema::rename('entrys', 'entries');
        }

        if (Schema::hasTable('entries')) {
            Schema::table('entries', function (Blueprint $table) {
                $table->string('title', 255)->nullable()->change();
                $table->text('body')->nullable()->change();
                $table->string('created_at')->nullable()->default(null)->change();
                $table->string('updated_at')->nullable()->default(null)->change();
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('genre')->nullable()->change();
                $table->string('created_at')->nullable()->default(null)->change();
                $table->string('updated_at')->nullable()->default(null)->change();
            });
        }

        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('created_at')->nullable()->default(null)->change();
                $table->string('updated_at')->nullable()->default(null)->change();
                $table->string('published_at')->nullable()->default(null)->change();
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('menu_icon_show', 5)->nullable();
                $table->string('created_at')->nullable()->default(null)->change();
                $table->string('updated_at')->nullable()->default(null)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
