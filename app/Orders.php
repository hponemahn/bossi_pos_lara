<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\OrderDetails;

class Orders extends Model
{
    protected $table = 'orders';
 	protected $fillable = ['id','total','order_date'];

 	public function orderdetails(): HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }

}

