<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const ACTIVE_CODE = 1;
    const INACTIVE_CODE = 0;

    protected $table = 'questions';

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
        return $this->hasMany(Question::class, 'question_id', 'id');
    }

    public function chapter() {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }
}
