<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_user extends Model
{
    //
     protected $table = 'permission_user';

    protected $primarykey = 'id';

    protected $fillable = [
        'user_id',
        'permission_id',
    ];
}
