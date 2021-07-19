<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->index();
            $table->string('username')->index();
            $table->string('status')->index();
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions_status');
    }
}
