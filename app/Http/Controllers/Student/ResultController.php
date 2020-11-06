<?php

namespace App\Http\Controllers\Student;

use Inertia\Inertia;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::whereUserId(Auth::id())
            ->latest()
            ->get()
            ->map
            ->only('id', 'result_id', 'exam_type', 'exam_name', 'total_mark', 'created_at');
        
        return Inertia::render('Student/Result/Index', [
            'results' => $results
        ]);
    }
}
