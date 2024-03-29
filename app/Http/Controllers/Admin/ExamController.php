<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Batch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ExamController extends Controller
{
    public function index(Request $request, Batch $batch)
    {
        return Inertia::render('Admin/Exam/Index', [
            'filters' => $request->all('search'),
            'exams' => Exam::whereBatchId($batch->id)
                ->filter($request->only('search'))
                ->withCount('questions')
                ->latest()
                ->paginate(10)
                ->transform(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'exam_id' => $exam->exam_id,
                        'name' => $exam->name,
                        'status' => ucfirst($exam->status),
                        'questions_count' => $exam->questions_count,
                        'total_question' => $exam->total_question,
                        'started_at' => $exam->started_at ? $exam->started_at->format('d/m/Y h:i A') : '',
                        'ended_at' => $exam->ended_at ? $exam->ended_at->format('d/m/Y h:i A') : '',
                    ];
                }),
            'batch' => $batch->only('batch_id', 'name')
        ]);
    }

 
    public function create(Batch $batch)
    {
        return Inertia::render('Admin/Exam/Create', [
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
        
        $data['exam_id'] = Str::random(11);
        $exam = Exam::create($data);
        return Redirect::route('exams.show', [$batch->batch_id, $exam->exam_id]);
    }

    public function show(Batch $batch, Exam $exam)
    {
        $exam['questions_count'] = $exam->questions->count();

        return Inertia::render('Admin/Exam/Show', [
            'exam' => [
                'id' => $exam->id,
                'exam_id' => $exam->exam_id,
                'exam_type' => $exam->exam_type,
                'name' => $exam->name,
                'total_question' => $exam->total_question,
                'questions_count' => $exam->questions_count,
                'pass_mark' => $exam->pass_mark,
                'duration' => $exam->duration,
                'has_negetive_mark' => $exam->has_negetive_mark,
                'negetive_mark' => $exam->negetive_mark,
                'started_at' => $exam->started_at ? $exam->started_at->format('Y-m-d\TH:i') : null,
                'ended_at' => $exam->ended_at ? $exam->ended_at->format('Y-m-d\TH:i') : null,
                'status' => $exam->status,
                'created_at' => now()->format('Y-m-d\TH:i')
            ],
            'batch' => $batch->only('id', 'batch_id', 'name')
        ]);
    }

    public function updateExamSchedule(Request $request, Exam $exam)
    {
        $request->validateWithBag('updateExamSchedule', [
            'started_at' => ['required', 'date'],
            'ended_at' => ['required', 'date'],
        ]);

        if ($request->started_at == $request->ended_at) {
            throw ValidationException::withMessages([
                'started_at' => [__('Exam end schedule must be greated than exam start schedule')],
            ])->errorBag('updateExamSchedule');
        }

        $exam->started_at = $request->started_at;
        $exam->ended_at = $request->ended_at;
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
