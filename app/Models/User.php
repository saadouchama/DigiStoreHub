<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Eloquent implements AuthenticatableContract
{
    use Billable, Authenticatable, HasApiTokens;

    protected $connection = 'mongodb';
    // Specify your collection if not default 'users'
    protected $collection = 'users';

    // Fillable, hidden, casts attributes as per your requirements
    protected $fillable = ['name', 'email', 'password', 'stripe_id', 'card_brand', 'card_last_four', 'trial_ends_at'];
    // Any additional methods or relationships
    protected $hidden = ['password'];
}
