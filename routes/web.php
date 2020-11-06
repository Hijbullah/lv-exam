<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Student\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::name('app.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function() {
        return Inertia\Inertia::render('Student/Dashboard');
    })->name('dashboard');
    Route::get('/batches', [StudentController::class, 'showBatch'])->name('batches.show');
    Route::post('/batch-request', [StudentController::class, 'batchRequest'])->name('batches.request');
    Route::middleware('batch.check')->group(function() {
        Route::get('/exam-center', [StudentController::class, 'showCurrentExam'])->name('exams.exam-center');
        Route::get('/exam-center/{exam:exam_id}', [StudentController::class, 'takeExam'])->name('exams.take-exam');
        Route::post('/finish-exam/{exam:exam_id}', [StudentController::class, 'finishExam'])->name('exams.finish');
        Route::get('/result-summary/{result:result_id}', [StudentController::class, 'showResultSummary'])->name('exams.result-summary');
        Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    });
});


// admin
Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', function() {
        return Inertia\Inertia::render('Dashboard');
    })->name('admin.dashboard');

    // batch
    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/batches/{batch:batch_id}', [BatchController::class, 'show'])->name('batches.show');
    Route::get('/batches/{batch:batch_id}/edit', [BatchController::class, 'edit'])->name('batches.edit');
    Route::put('/batches/{batch:batch_id}', [BatchController::class, 'update'])->name('batches.update');
    Route::delete('/batches/{batch:batch_id}', [BatchController::class, 'destroy'])->name('batches.destroy');

    // students

    Route::get('/batches/{batch}/students', [BatchController::class, 'showStudents'])->name('batches.students.index');

    // exams
    Route::get('/batches/{batch:batch_id}/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/batches/{batch:batch_id}/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/batches/{batch:batch_id}/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/batches/{batch:batch_id}/exams/{exam:exam_id}', [ExamController::class, 'show'])->name('exams.show');
    Route::put('/exams/update-basic-info/{exam:exam_id}', [ExamController::class, 'updateBasicInfo'])->name('exams.update-basic-info');
    Route::put('/exams/update-schedule/{exam:exam_id}', [ExamController::class, 'updateExamSchedule'])->name('exams.update-schedule');
    Route::post('/exams/enable-negetive-mark/{exam:exam_id}', [ExamController::class, 'enableNegetiveMark'])->name('exams.enable-negetive-mark');
    Route::post('/exams/update-negetive-mark/{exam:exam_id}', [ExamController::class, 'updateNegetiveMark'])->name('exams.update-negetive-mark');
    Route::post('/exams/publish-exam/{exam:exam_id}', [ExamController::class, 'publishExam'])->name('exams.publish');
    Route::delete('/exams/{exam:exam_id}', [ExamController::class, 'destroy'])->name('exams.destroy');

    // questions
    Route::get('/exams/{exam:exam_id}/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::post('/exams/{exam:exam_id}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');


});


