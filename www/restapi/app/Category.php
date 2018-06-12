<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    const IS_VISIBLE = 'is_visible';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}