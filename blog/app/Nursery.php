<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Nursery extends Model
{
    
    protected $fillable = [
        'Name','Address','Phone','Banner','latitude','longitude'
    ];

}
