<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * get all documents where user is admin
     *
     * Undocumented function long description
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @throws conditon
     **/
    public function documentsAdmin()
    {
        return $this->hasMany(DocumentStore::class,'user_admin','id');
    }

    /**
     * get all serials Crypto pro keys of user
     *
     * Undocumented function long description
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @throws conditon
     **/
    public function CSPserials()
    {
        return $this->hasMany(Cspusers::class,'userid','id');
    }

}
