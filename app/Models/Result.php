<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes,
        Uuid;

    const STATUS_CODES = [
        'done'   => 1,
        'doing'  => 0,
    ];


    protected $fillable = [
        'test_id',
        'student_id',
        'correct_ans',
        'is_completed',
        'read_at',
        'status',
        'timeout'
    ];

    protected $dates = [
        'read_at'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
