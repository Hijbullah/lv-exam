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
            $table->uuid('exam_id');
            $table->foreignId('batch_id')
                    ->constrained()
                    ->onDelete('cascade');

            $table->string('name');
            $table->string('exam_type')->nullable();
            $table->text('total_question')->nullable();
            $table->string('pass_mark')->nullable()->comment('percentage or number');
            $table->integer('duration')->nullable()->comment('in minute');
            $table->boolean('has_negetive_mark')->default(false);
            $table->float('negetive_mark')->default(0.25);
            $table->date('exam_date')->nullable();
            $table->time('exam_start')->nullable();
            $table->time('exam_end')->nullable();

            $table->json('subject_data')->nullable();
            $table->enum('status', ['pending', 'published', 'closed'])->default('pending');

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
        Schema::dropIfExists('exams');
    }
}
