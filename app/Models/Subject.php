<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Traits\Method\SubjectMethod;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Attribute\SubjectAttribute;

class Subject extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SubjectAttribute;
    use SubjectMethod;

    const ACTIVE_CODE = 1;
    const INACTIVE_CODE = 0;
    const TAB_TYPES = [
        'subjects'   => 'subjects',
        'chapters'      => 'chapters',
        'deleted_chapters'  => 'deleted_chapters'
    ];


    protected $fillable = [
        'name',
        'credit',
        'is_actived',
        'slug',
        'abbreviation',
        'deleted_at'
    ];

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return [
            //Tên cot luu slug
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function chapters() {
        return $this->hasMany(Chapter::class)->orderBy('name', 'asc')->paginate(25);
    }

    public function lecturers() {
        return $this->belongsToMany(
            User::class,
            'lecturers',
            'subject_id',
            'lecturer_id'
        )->withTimestamps();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
