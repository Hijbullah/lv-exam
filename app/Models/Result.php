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

    // public function results()
    // {
    //     return $this->hasMany('App\Models\Result');
    // }

    public function exam()
    {
        return $this->belongsTo('App\Models\Exam');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('total_mark', 'like', '%'.$search.'%')
                    ->orWhereHas('student', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    });
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
