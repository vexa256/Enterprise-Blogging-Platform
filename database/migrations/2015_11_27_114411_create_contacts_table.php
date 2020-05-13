<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->integer('category_id')->unsigned();
                $table->integer('label_id')->unsigned();
                $table->string('name')->nullable();
                $table->string('email', 155)->nullable();
                $table->string('subject', 255)->nullable();
                $table->text('text')->nullable();
                $table->boolean('read')->nullable();
                $table->boolean('stared')->nullable();
                $table->boolean('important')->nullable();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::drop('contacts');
    }
}
