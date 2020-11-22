<?php

use Illuminate\Support\Facades\Route;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/dashboard');
Route::name('app.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/batches', [StudentController::class, 'showBatch'])->name('batches.show');
    Route::post('/batch-request', [StudentController::class, 'batchRequest'])->name('batches.request');
    Route::middleware('batch.check')->group(function() {
        Route::get('/dashboard', function() {
            return Inertia\Inertia::render('Student/Dashboard');
        })->name('dashboard');
        Route::get('/exam-center', [StudentController::class, 'showCurrentExam'])->name('exams.exam-center');
        Route::get('/exam-center/{exam:exam_id}', [StudentController::class, 'takeExam'])->name('exams.take-exam');
        Route::post('/finish-exam/{exam:exam_id}', [StudentController::class, 'finishExam'])->name('exams.finish');
        Route::get('/result-summary/{result:result_id}', [StudentController::class, 'showResultSummary'])->name('exams.result-summary');
        Route::get('/results', [ResultController::class, 'index'])->name('results.index');
        Route::get('/results/{result:result_id}', [ResultController::class, 'showDetailsResult'])->name('results.details');
        
    });
});



