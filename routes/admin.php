<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group and default prefix is "admin". Now create something great!
|
*/

Route::redirect('/', '/admin/dashboard');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admins.login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('admins.logout');

Route::get('/after-login', function(Request $request)
{
    return $request->user('admin');
})->middleware('auth:admin');

Route::post('/editor/upload', function(Request $request) {
    return response()->json([
        'src' => 'https://images.unsplash.com/photo-1593642532009-6ba71e22f468?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80'
    ]);
});


// admin
Route::middleware(['auth:admin', 'verified'])->group(function() {
    Route::get('/dashboard', function() {
        return Inertia\Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    // setting
    Route::get('/settings', []);

    // batch
    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/batches/{batch:batch_id}', [BatchController::class, 'show'])->name('batches.show');
    Route::get('/batches/{batch:batch_id}/edit', [BatchController::class, 'edit'])->name('batches.edit');
    Route::put('/batches/{batch:batch_id}', [BatchController::class, 'update'])->name('batches.update');
    Route::delete('/batches/{batch:batch_id}', [BatchController::class, 'destroy'])->name('batches.destroy');

    // students

    Route::get('/batches/{batch:batch_id}/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students/{student}/approval', [StudentController::class, 'approveStudent'])->name('students.approval');

    // results 
    Route::get('batches/{exam:exam_id}/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('results/{result:result_id}', [ResultController::class, 'show'])->name('results.show');
    Route::post('/publish-result/{exam:exam_id}', [ResultController::class, 'publishResult'])->name('results.publish-result');

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
    Route::post('/exams/{exam:exam_id}/questions-upload-with-file', [QuestionController::class, 'uploadQuestionsFile'])->name('questions.upload-questions-file');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});


