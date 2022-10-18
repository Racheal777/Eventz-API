<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    //adding reviewable id and type because the review table will have a relationship with both the
    //organizers and the events
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->integer('ratings');
            $table->unsignedBigInteger('user_id');
            $table->integer('reviewable_id');
            $table->string('reviewable_type');
            $table->timestamp('date_added')->nullable();
            $table->timestamps();

            //ensuring that the foreign key takes the user_id and delete every item
            //related to the user once the main item has been deleted
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
