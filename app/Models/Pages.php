<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title', 'page_description', 'page_meta_keyword','page_meta_description', 'page_image','status'
    ];
}
