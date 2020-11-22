<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::whereUserId(Auth::id())
            ->latest()
            ->select('id', 'result_id', 'exam_type', 'exam_name', 'total_mark', 'created_at')
            ->paginate(10)
            ->transform(function($result) {
                return [
                    'id' => $result->id,
                    'result_id' => $result->result_id,
                    'exam' => $result->exam_type . ': ' . $result->exam_name,
                    'total_mark' => $result->total_mark,
                    'exam_date' => $result->created_at->format('d/m/Y h:i A')
                ];
            });
        
        return Inertia::render('Student/Result/Index', [
            'results' => $results
        ]);
    }

    public function showDetailsResult(Result $result)   
    {
        if (!$result->is_published) {
            return Redirect::route('app.exams.result-summary', $result->result_id);
        }

        return Inertia::render('Student/Result/Details', [
            'result' => $result
        ]);
    }
}
