<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function index(Exam $exam)
    {
        return  Inertia::render('Admin/Result/Index', [
            'filters' => \Request::all('search'),
            'batch' => $exam->batch->only('id', 'batch_id', 'name'),
            'exam' => $exam->only('id', 'exam_id', 'name'),
            'results' => $exam->results()
                    ->orderBy('position', 'asc')
                    ->with('student:id,name')
                    ->filter(\Request::only('search'))
                    ->paginate(10)
                    ->transform(function ($result) {
                        return [
                            'result_id' => $result->result_id,
                            'position' => $result->position,
                            'total_mark' => $result->total_mark,
                            'exam_taken_at' => $result->created_at->format('d-m-Y g:m:s a'),
                            'student' => $result->student->only('id', 'name')
                        ];
                    })
        ]);
    }

    public function show(Result $result)
    {
        return Inertia::render('Admin/Result/Show', [
            'result' => $result,
            'exam' => $result->exam->only('exam_id')
        ]);
    }

    public function publishResult(Exam $exam)
    {
        $position = 0;
        $currentMark = 0; //8
        $exam->results()
            ->orderBy('total_mark', 'desc')
            ->chunk(100, function($results) use(&$position, &$currentMark) {
                foreach ($results as $result) {
                    if($currentMark != $result->total_mark) // 0 != 8
                    {
                        $currentMark = $result->total_mark;
                        $position += 1;
                    }

                    $result->update(['position' => $position, 'is_published' => true]);
                }
            });
        return back();
    }
}
