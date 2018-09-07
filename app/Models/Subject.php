<?php

namespace App\Models;

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
