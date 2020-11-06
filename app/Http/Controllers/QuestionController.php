<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam)
    {
        return Inertia::render('Question/Index', [
            'exam' => $exam->only('id', 'exam_id', 'name', 'total_question'),
            'batch_id' => $exam->batch->batch_id,
            'questions' => Question::where('exam_id', $exam->id)->get()->map(function($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'option_a' => $question->option_a, 
                    'option_b' => $question->option_b, 
                    'option_c' => $question->option_c, 
                    'option_d' => $question->option_d, 
                    'answer' => $question->answer
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exam $exam)
    {
        $data = $request->validateWithBag('createQuestion', [
            'question' => ['required', 'string', 'min:3', 'max:255'],
            'option_a' => ['required', 'string', 'min:2', 'max:255'],
            'option_b' => ['required', 'string', 'min:2', 'max:255'],
            'option_c' => ['required', 'string', 'min:2', 'max:255'],
            'option_d' => ['required', 'string', 'min:2', 'max:255'],
            'answer' => ['required', 'string']
        ]);

        $exam->questions()->create($data);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validateWithBag('updateQuestion', [
            'question' => ['required', 'string', 'min:3', 'max:255'],
            'option_a' => ['required', 'string', 'min:2', 'max:255'],
            'option_b' => ['required', 'string', 'min:2', 'max:255'],
            'option_c' => ['required', 'string', 'min:2', 'max:255'],
            'option_d' => ['required', 'string', 'min:2', 'max:255'],
            'answer' => ['required', 'string']
        ]);

        $question->question = $request->question;
        $question->option_a = $request->option_a;
        $question->option_b = $request->option_b;
        $question->option_c = $request->option_c;
        $question->option_d = $request->option_d;
        $question->answer = $request->answer;
        $question->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return back();
    }
}
