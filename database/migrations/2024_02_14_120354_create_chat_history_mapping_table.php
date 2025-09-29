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
    {
        Schema::create('chat_history_mapping', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_id')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->text('message_text')->nullable();
            $table->dateTime('time')->nullable();
            $table->integer('word_count')->nullable();
            $table->integer('image_count')->nullable();
            $table->text('images')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_history_mapping');
    }
};
