<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->drop('posts');

        Schema::connection($this->connection)->table('posts', function (Blueprint $collection) {
            $collection->increments('id');
            $collection->unsignedInteger('user_id')->index();
            // TODO: May just be string types
            $collection->text('title');
            $collection->text('description');
            $collection->timestamps();
        });
    }

//    /**
//     * Reverse the migrations.
//     *
//     * @return void
//     */
//    public function down()
//    {
//        // TODO: To successfully drop the table I had to move this to the up function. https://github.com/jenssegers/laravel-mongodb/issues/1241
//
//        Schema::connection($this->connection)->drop('posts');
//    }
}
