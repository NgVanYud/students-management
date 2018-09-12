<?php

namespace App\Models;

use App\Models\Traits\Attribute\ChapterAttribute;
use App\Models\Traits\Method\ChapterMethod;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;
    use Sluggable;
    use ChapterAttribute;
    use ChapterMethod;

    const ACTIVE_CODE = 1;
    const INACTIVE_CODE = 0;

    protected $fillable = [
        'name',
        'subject_id',
        'slug',
        'is_actived',
    ];

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            //Tên cot luu slug
            'slug' => [
                'source' => ['subject.name', 'name']
            ]
        ];
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query, $status = true)
    {
        return $query->where('is_actived', $status);
    }
}
