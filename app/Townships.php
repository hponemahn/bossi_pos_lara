<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Townships extends Model
{
    protected $table = 'townships';
 	protected $fillable = ['id','name'];
}
