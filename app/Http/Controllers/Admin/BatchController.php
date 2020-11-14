<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Batch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/Batch/Index', [
            'filters' => $request->all('search'),
            'batches' => Batch::filter($request->only('search'))
                ->latest()
                ->paginate()
                ->transform(function ($batch) {
                    return [
                        'id' => $batch->id,
                        'batch_id' => $batch->batch_id,
                        'name' => $batch->name,
                    ];
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Batch/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validateWithBag('createBatch', [
            'name' => ['required', 'unique:batches', 'max:255'],
            'detail' => ['required'],
        ]);

        Batch::create([
            'name' => $request->name,
            'batch_id' => Str::random(11),
            'detail' => $request->detail
        ]);

        return Redirect::route('batches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        return Inertia::render('Admin/Batch/Show', [
            'batch' => $batch->only('id', 'batch_id', 'name', 'detail')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        return Inertia::render('Admin/Batch/Edit', [ 
            'batch' => $batch->only('id', 'batch_id', 'name', 'detail')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validateWithBag('updateBatch', [
            'name' => ['required', 'unique:batches,name,' .  $batch->id, 'max:255'],
            'detail' => ['required'],
        ]);

        $batch->name = $request->name;
        $batch->detail = $request->detail;
        $batch->save();

        return Redirect::route('batches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Batch $batch)
    {
        if (! Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ])->errorBag('deleteBatch');
        }

        $batch->delete();
        return Redirect::route('batches.index');
    }  
}
