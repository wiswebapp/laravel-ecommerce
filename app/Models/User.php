<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes, HasRoles, HasFactory;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password', 'phonecode' ,'phone' ,'country' ,'state' ,'city' ,'zipcode' ,'dob' ,'imgName', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserCountry()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

    public function getUserState()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }

    public function getFullNameAttribute(){
       return $this->fname . ' ' . $this->lname;
    }

}
