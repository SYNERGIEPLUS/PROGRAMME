<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammeTravail extends Model
{
    //
    protected $fillable = ['groupe', 'date', 'ctx', 'verif', 'generale'];

    protected $casts = [
        'generale' => 'array',
        'date' => 'date',
    ];
}
