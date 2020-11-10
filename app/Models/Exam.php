<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'batch_id',
        'name',
        'exam_type',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }
}
