<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['name', 'surname', 'password', 'email'];

    /**
     * @var array
     */
    protected $hidden = ['password', 'reset_password'];

    /**
     * @var array
     */
    protected $dates = ['updated_at', 'created_at'];
}
