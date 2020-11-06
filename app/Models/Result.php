<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'exam_meta_data' => 'array',
    ];

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    public function exam()
    {
        return $this->belongsTo('App\Models\Exam');
    }
}
