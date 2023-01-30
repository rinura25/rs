<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'id',
        'name',
        'city',
        'country',
    ];
    // protected $guarded = [

    // ];
}
