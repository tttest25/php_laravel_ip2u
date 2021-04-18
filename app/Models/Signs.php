<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'signobj',
        'signpath',
    ];
      // wotk with json - to get arrat
      protected $casts = [
        'signobj' => 'array'

    ];

    /**
     * belongs to files
     *
     * releation
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function files()
    {
        return $this->belongsTo(Files::class);
    }
}
