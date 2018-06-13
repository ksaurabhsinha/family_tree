<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use Uuids;

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_PARENT_ID = 'parent_id';
    const COLUMN_SLUG = 'slug';
    const COLUMN_IS_VISIBLE = 'is_visible';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id', 'is_visible', 'slug',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
