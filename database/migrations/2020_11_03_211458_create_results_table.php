<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('result_id')->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('exam_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->integer('position')->nullable();
            $table->string('exam_type');
            $table->string('exam_name');
            $table->integer('total_question');
            $table->integer('total_answered');
            $table->integer('correct_answer');    
            $table->integer('wrong_answer');  
            $table->decimal('total_mark');
            $table->string('exam_duration');  
            $table->json('exam_meta_data');
            $table->boolean('is_published')->default(false);

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
        Schema::dropIfExists('results');
    }
}
