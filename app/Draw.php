<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categorie_id', 'time',
    ];
}
