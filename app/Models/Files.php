<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    /**
     * return document of sign object
     *
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    /*public function FunctionName(Type $var = null)
    {
        # code...
    }*/

    /**
     * releation to file
     *
     * Undocumented function long description
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function signs()
    {
        return $this->hasMany(Signs::class);
    }
}
