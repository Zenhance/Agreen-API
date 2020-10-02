<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    
    protected $fillable = [
        'Title','Image','Nursery_ID'
    ];
}
