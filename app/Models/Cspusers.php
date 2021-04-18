<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Cspusers extends Authenticatable
{
    use Notifiable;

    protected $guard = 'cspuser';

    protected $fillable = [
        'cid','userid',
    ];

    protected $hidden = [
        'serialNumber'
    ];
}
