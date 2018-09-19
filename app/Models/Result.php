<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes,
        Uuid;

    protected $fillable = [
        'uuid',
        'test_id',
        'student_id',
        'correct_ans',
        'is_completed',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
