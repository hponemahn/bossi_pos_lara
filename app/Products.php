<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Category;

class Products extends Model
{
    protected $table = 'products';
 	protected $fillable = ['id','name','category_id','stock','buy_price','sell_price','discount_price','sku','barcode','is_damaged','remark'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
