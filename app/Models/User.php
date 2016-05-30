<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['name', 'surname', 'password', 'email'];

    protected $hidden = ['password', 'reset_password'];

    protected $dates = ['updated_at', 'created_at'];
}
