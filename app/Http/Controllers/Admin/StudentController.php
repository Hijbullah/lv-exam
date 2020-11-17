<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index(Request $request, Batch $batch)
    {
        return Inertia::render('Admin/Student/Index', [
            'filters' => $request->all('search', 'type'),
            'batch' => $batch->only('id', 'batch_id', 'name'),
            'students' => $batch->students()
                ->filter($request->only('search', 'type'))
                ->latest()
                ->paginate()
                ->transform(function ($student) {
                    return [
                        'id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                        'is_approved' => $student->is_batch_approved ? true : false,
                        'created_at' => $student->created_at->diffForHumans(),
                    ];
                })
        ]);  
    }

    public function approveStudent(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update(['is_batch_approved' => $request->status]);
        return back();
    }
}
