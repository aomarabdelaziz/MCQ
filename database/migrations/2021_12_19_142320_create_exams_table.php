<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('creators')->onDelete('cascade');
            $table->string('exam_name');
            $table->string('slug')->unique();
            $table->boolean('request_access')->default(0);
            $table->integer('number_of_questions');
            $table->integer('category_id');
            $table->string('difficulty');
            $table->string('type');
            $table->enum('status' , ['pending' , 'approved'])->default('pending');
            $table->timestamp('activated_at')->nullable()->default(now());
            $table->timestamp('deactivated_at')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
