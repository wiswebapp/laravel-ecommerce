<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner','name','email','password','address','location','country','state','city','zipcode','store_timing','image','status'
    ];

    public function getCountry()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

    public function getState()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class);
    }

    public function getStoreTimingAttribute($data)
    {
        return json_decode($data);
    }
}
