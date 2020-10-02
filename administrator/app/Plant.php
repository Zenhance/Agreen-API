<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Plant extends Model
{
    protected $table = 'plant';

    public $timestamps = false;
    
    protected $fillable = [
        'Title','Description','Price'
    ];
}