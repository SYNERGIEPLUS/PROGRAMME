<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnes extends Model
{
    //
    protected $fillable = [
        'nom',
        'code',
        'role',
        'telephone',
    ];
}
