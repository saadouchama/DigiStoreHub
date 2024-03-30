<?php

namespace App\Models;


use Laravel\Cashier\Billable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Eloquent implements Authenticatable
{
    use HasApiTokens, Billable, Notifiable, AuthenticatableTrait;

    protected $connection = 'mongodb';
    // Specify your collection if not default 'users'
    protected $collection = 'users';

    // Fillable, hidden, casts attributes as per your requirements
    protected $fillable = ['name', 'email', 'password', 'remember_token', 'stripe_id', 'card_brand', 'card_last_four', 'trial_ends_at', 'updated_at', 'created_at'];
    // Any additional methods or relationships
    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
