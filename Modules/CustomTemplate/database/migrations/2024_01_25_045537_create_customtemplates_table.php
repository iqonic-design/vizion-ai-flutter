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
        Schema::create('customtemplates', function (Blueprint $table) {
 
            $table->id();
            $table->string('template_name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('inculde_voice_tone')->default(1);
            $table->text('userinput_list')->nullable();
            $table->text('option_data')->nullable();
            $table->text('custom_prompt')->nullable();

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
        Schema::dropIfExists('customtemplates');
    }
};
