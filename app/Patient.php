<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'birthDate',
        'deceasedBoolean',
    ];
    // protected $guarded = [

    // ];
}
