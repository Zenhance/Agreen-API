<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Nursery extends Model
{
    public $timestamps = false;

    protected $table = 'nursery';

    protected $fillable = [
        'ID','Name', 'Address', 'Phone', 'Banner', 'Location'
    ];

    
}
