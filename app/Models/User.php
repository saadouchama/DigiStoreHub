<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Eloquent implements AuthenticatableContract
{
    use Authenticatable, HasApiTokens;

    protected $connection = 'mongodb';
    // Specify your collection if not default 'users'
    protected $collection = 'users';

    // Fillable, hidden, casts attributes as per your requirements
    protected $fillable = ['name', 'email', 'password'];
    // Any additional methods or relationships
    protected $hidden = ['password'];
}
