<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    const male = 1;
    const female = 2;
    const both = 4;

    public $timestamps = false;
}
