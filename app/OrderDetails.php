<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Orders;

class OrderDetails extends Model
{
    protected $table = 'order_details';
 	protected $fillable = ['id','orders_id ','product_id','qty','price'];

 	public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }
}


