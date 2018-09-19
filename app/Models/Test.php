<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Traits\Attribute\TestAttribute;
use App\Models\Traits\Method\TestMethod;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use SoftDeletes,
        Uuid,
        TestAttribute,
        TestMethod;

    protected $fillable = [
        'code',
        'num_questions',
        'uuid',
        'examination_id',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function examination() {
        return $this->belongsTo(Examination::class, 'examination_id', 'id');
    }

    public function questions() {
        return $this->belongsToMany(
            Question::class,
            'question_test',
            'test_id',
            'question_id'
        );
    }

    public function students() {
        return $this->belongsToMany(
            User::class,
            'results',
            'test_id',
            'student_id'
        )
            ->as('result')
            ->withTimestamps()
            ->withPivot(
            'uuid', 'correct_ans', 'is_completed', 'deleted_at'
            );
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
