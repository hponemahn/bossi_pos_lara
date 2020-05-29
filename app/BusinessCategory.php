<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $table = 'business_cats';
 	 protected $fillable = ['id','name'];
}
