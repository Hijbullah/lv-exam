<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Batch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ExamController extends Controller
{
    public function index(Batch $batch)
    {
        return Inertia::render('Exam/Index', [
            'exams' => Exam::whereBatchId($batch->id)->latest()->get()->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'exam_id' => $exam->exam_id,
                    'name' => $exam->name,
                ];
            }),
            'batch' => $batch->only('batch_id', 'name')
        ]);
    }

 
    public function create(Batch $batch)
    {
        return Inertia::render('Exam/Create', [
            'batch' => $batch->only('id', 'batch_id', 'name')
        ]);
    }

    public function store(Request $request, Batch $batch)
    {
        $data = $request->validateWithBag('createExam', [
            'batch_id' => ['required'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'exam_type' => ['required', 'string', 'min:2', 'max:255']
        ]);
        
        $data['exam_id'] = (string) Str::uuid();
        $exam = Exam::create($data);
        return Redirect::route('exams.show', [$batch->batch_id, $exam->exam_id]);
    }

    public function show(Batch $batch, Exam $exam)
    {
        $exam['questions_count'] = $exam->questions->count();

        return Inertia::render('Exam/Show', [
            'exam' => $exam,
            'batch' => $batch->only('id', 'batch_id', 'name')
        ]);
    }

    public function updateExamSchedule(Request $request, Exam $exam)
    {
        $request->validateWithBag('updateExamSchedule', [
            'exam_date' => ['required', 'date'],
            'exam_start' => ['required'],
            'exam_end' => ['required'],
        ]);

        $exam->exam_date = $request->exam_date;
        $exam->exam_start = $request->exam_start;
        $exam->exam_end = $request->exam_end;
        $exam->save();
        return back();
    }
    
    public function updateBasicInfo(Request $request, Exam $exam)
    {
        $request->validateWithBag('updateExamBasicInfo', [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'exam_type' => ['required', 'string', 'min:2', 'max:255'],
            'total_question' => ['required', 'numeric', 'min:2', 'max:200'],
            'pass_mark' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
        ]);

        $exam->name = $request->name;
        $exam->exam_type = $request->exam_type;
        $exam->total_question = $request->total_question;
        $exam->pass_mark = $request->pass_mark;
        $exam->duration = $request->duration;
        $exam->save();
        return back()->with('status', 'basic-information-updated');
    }

    public function enableNegetiveMark (Exam $exam)     
    {
        if($exam->has_negetive_mark)
        {
            $exam->has_negetive_mark = false;
            $exam->negetive_mark = 0.25;
        }else{
            $exam->has_negetive_mark = true;
        }

        $exam->save();
        return back();
    }

    public function updateNegetiveMark(Request $request, Exam $exam)
    {
        $request->validateWithBag('updateNegetiveMark', [
            'negetive_mark' => ['required', 'numeric', 'min:0.25', 'max:1']
        ]);

        $exam->negetive_mark = $request->negetive_mark;
        $exam->save();
        return back();
    }

    public function publishExam(Exam $exam) 
    {
        if($exam->status == 'published')
        {
            $exam->status = 'pending';
        }else{
            $exam->status = 'published';
        }
        $exam->save();
        return back();
    }

    public function destroy(Request $request, Exam $exam)
    {
        if (! Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ])->errorBag('deleteExam');
        }

        $exam->delete();
        return Redirect::route('exams.index', $request->batch_id);
    }
}
