<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [];
    protected $guarded = [];

    public function getProducts($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        if (isset($args['search'])) {
            $res = DB::table('products')
                ->orWhere('name', $args['search'])
                ->orWhere('barcode', $args['search'])
                ->orWhere('sku', $args['search']);
        } else {
            $res = DB::table('products');
        }

        return $res;
    }
}   
