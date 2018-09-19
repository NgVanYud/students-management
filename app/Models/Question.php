<?php

namespace App\Models;

use App\Models\Traits\Attribute\QuestionAttribute;
use App\Models\Traits\Method\QuestionMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use QuestionAttribute;
    use QuestionMethod;
    use SoftDeletes;

    const ACTIVE_CODE = 1;
    const INACTIVE_CODE = 0;

    protected $table = 'questions';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'content',
        'is_actived',
        'chapter_id',
        'subject_id',
        'creater_id',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function scopeActive($query, $status = true)
    {
        return $query->where('is_actived', $status);
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function chapter() {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function tests(){
        return $this->belongsToMany(
            Test::class,
            'question_test',
            'question_id',
            'test_id'
        );
    }
}
