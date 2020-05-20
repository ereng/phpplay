<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public $timestamps = false;
    public $fillable = ['user_id', 'role_id'];
}