<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    const CODE_CORRECT = 1;
    const CODE_INCORRECT = 0;

    protected $table = 'answers';

    protected $fillable = [
        'content',
        'question_id',
        'is_correct',
    ];

    public function question() {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
