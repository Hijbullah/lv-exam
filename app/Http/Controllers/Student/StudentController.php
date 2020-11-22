<?php

namespace App\Http\Controllers\Student;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Batch;
use App\Models\Result;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function showBatch()
    { 
        return Inertia::render('Student/Batch/Show', [
            'current_batch' => function() {
                if(!Auth::user()->batch_id) {
                    return null;
                }
                return [
                    'name' => Auth::user()->batch->name,
                    'is_batch_approved' => Auth::user()->is_batch_approved
                ];
            }, 
            'batches' => Batch::latest()->get(['id', 'batch_id', 'name'])
        ]);
    }

    public function batchRequest(Request $request)
    {
        $request->validateWithBag('requestBatch', [
            'batch_id' => ['required', 'string', 'min:8']
        ]);

        $batch = Batch::where('batch_id', $request->batch_id)->first(['id', 'batch_id']);

        if (! $batch) {
            throw ValidationException::withMessages([
                'batch_code' => [__('Something Wrong. Please, try again.')],
            ])->errorBag('requestBatch');
        }

        $request->user()->batch_id = $batch->id;
        $request->user()->save();
        return back();
    }

    public function showCurrentExam()
    {
        $exam = Exam::whereBatchId(Auth::user()->batch_id)
                ->whereStatus('published')
                ->where('started_at', '<=', Carbon::now())
                ->where('ended_at', '>=', Carbon::now())
                ->latest()
                ->first(['id', 'exam_id', 'name', 'exam_type', 'started_at', 'ended_at']);
        
        return Inertia::render('Student/Exam/ExamCenter', [
            'exam' => function() use ($exam) {
                if(!$exam) {
                    return;
                }

                return [
                    'id' => $exam->id,
                    'exam_id' => $exam->exam_id,
                    'exam_type' => $exam->exam_type,
                    'name' => $exam->name,
                    'started_at' => $exam->started_at->format('d/m/Y h:i A'),
                    'ended_at' => $exam->ended_at->format('j F\\, Y h:i A'),
                ];
            }
        ]);
    }

    public function takeExam(Exam $exam)
    {
        return Inertia::render('Student/Exam/TakeExam', [
            'exam' => [
                'id' => $exam->id,
                'exam_id' => $exam->exam_id,
                'exam_type' => $exam->exam_type,
                'name' => $exam->name,
                'total_question' => $exam->total_question,
                'duration' => $exam->duration,
                'exam_date' => Carbon::create($exam->exam_date)->format('d/m/Y'),
                'exam_start' => Carbon::create($exam->exam_start)->format('g:i a'),
                'exam_end' => Carbon::create($exam->exam_end)->format('g:i a'),
                'questions' => $exam->questions()->get()->map(function($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'options' => [
                            'a' => $question->option_a,
                            'b' => $question->option_b,
                            'c' => $question->option_c,
                            'd' => $question->option_d,
                        ],
                        'answer' => $question->answer  
                    ];
                }),
            ]
        ]);
    }

    public function finishExam(Exam $exam, Request $request)
    {
        // get the result data
        $questions = $exam->questions()->get();
        // $questions = $exam->questions()->get()->map->only('id','question', 'option_a', 'option_b', 'option_c', 'option_d', 'answer');
        $answerSheet = collect($request->answerSheet);

        $totalAnswered = 0;
        $correctAnswer = 0;
        $wrongAnswer = 0;
        $negetiveMark = 0;
        $questionData = [];

        // evaluating result
        if($answerSheet->count()) {
            foreach ($questions as $question) {
                $answer = $answerSheet->firstWhere('id', $question->id);

                if($answer) {
                    if($question->answer === $answer['answer']) {
                        $correctAnswer += 1;
                    }else {
                        $wrongAnswer += 1;
                    }

                    $totalAnswered += 1;
                }

                $questionData[] = [
                    'question' => $question->question,
                    'options' => [
                        'a' => $question->option_a,
                        'b' => $question->option_b,
                        'c' => $question->option_c,
                        'd' => $question->option_d,
                    ],
                    'answer' => $question->answer,
                    'selectedAnswer' => $answer ? $answer['answer'] : null
                ];
            };
        }

        // negetive mark
        if($exam->has_negetive_mark) {
            $negetiveMark = $wrongAnswer * $exam->negetive_mark;
        }

        // total result
        $totalMark = ($correctAnswer - $wrongAnswer) - $negetiveMark;
        $examDuration = '00.5.00';
        // storing result
       
        $result = Result::create([
            'result_id' => Str::random(10),
            'user_id' => Auth::id(),
            'exam_id' => $exam->id,
            'exam_type' => $exam->exam_type,
            'exam_name' => $exam->name,
            'total_question' => $exam->total_question,
            'total_answered' => $totalAnswered,
            'correct_answer' => $correctAnswer,
            'wrong_answer' => $wrongAnswer,
            'total_mark' => $totalMark,
            'exam_duration' => $examDuration,
            'exam_meta_data' => $questionData
        ]);

        return Redirect::route('app.exams.result-summary', $result->result_id);
    }

    public function showResultSummary(Result $result)
    {
        return Inertia::render('Student/Exam/ResultSummary', [
            'result' => [
                'id' => $result->id,
                'result_id' => $result->result_id,
                'exam_type' => $result->exam_type,
                'exam_name' => $result->exam_name,
                'total_question' => $result->total_question,
                'correct_answer' => $result->correct_answer,
                'wrong_answer' => $result->wrong_answer,
                'total_mark' => $result->total_mark,
                'position' => $result->position,
                'is_published' => $result->is_published
            ]
        ]);
    }
}
