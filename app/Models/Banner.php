<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'banner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'title', 'path', 'order', 'status',
    ];

}
