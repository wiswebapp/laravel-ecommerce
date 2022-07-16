<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Country::class, 'id');
    }

    public function children()
    {
        return $this->hasOne(City::class, 'state_id');
    }
}
