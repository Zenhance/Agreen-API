<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    protected $fillable = ['Name','Mobile','Nursery_ID'];
}