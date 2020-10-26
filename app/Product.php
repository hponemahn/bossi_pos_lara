<?php

namespace App;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
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

    public function getCapital($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        $res;

        if ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m") {

            $res = DB::table('products')->select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
                ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
                ->groupby('month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC');

        } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {

            $res = DB::table('products')->select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"))
                ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
                ->groupby('year')
                ->orderBy('year', 'DESC');

        } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

            $res = DB::table('products')->select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%d') day"), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
                ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
                ->groupby('day', 'month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC')
                ->orderBy('day', 'DESC');

        } elseif ($args['filter'] == "y") {
            $res = DB::table('products')->select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"))
                ->groupby('year')
                ->orderBy('year', 'DESC');

        } elseif ($args['filter'] == "d") {
            $res = DB::table('products')->select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%d') day"), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
                ->groupby('day', 'month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC')
                ->orderBy('day', 'DESC');

        } else {
            $res = DB::table('products')->select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
            // ->whereBetween('created_at', [$dateS, $dateE])
                ->groupby('month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC');

        }

        return $res;
    }

    public function getBuy($_, array $args)
    {
        $res;

        if ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "m") {

            $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
                ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
                ->groupby('month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC');
            // ->limit(5)
            // ->reverse()

        } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "y") {

            $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"))
                ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
                ->groupby('year')
                ->orderBy('year', 'DESC');
        } elseif ($args['startDate'] != "0" && $args['endDate'] != "0" && $args['filter'] == "d") {

            $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%d') day"), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
                ->whereBetween('created_at', [$args['startDate'], $args['endDate']])
                ->groupby('day', 'month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC')
                ->orderBy('day', 'DESC');
        } elseif ($args['filter'] == "y") {
            $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"))
                ->groupby('year')
                ->orderBy('year', 'DESC');
        } elseif ($args['filter'] == "d") {
            $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%d') day"), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
                ->groupby('day', 'month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC')
                ->orderBy('day', 'DESC');
        } else {
            $res = Product::select(DB::raw('SUM(buy_price) as total'), DB::raw("DATE_FORMAT(created_at, '%Y') year"), DB::raw("DATE_FORMAT(created_at, '%m') month"), DB::raw('MONTH(created_at) months'))
            // ->whereBetween('order_date', [$dateS, $dateE])
                ->groupby('month', 'year', 'months')
                ->orderBy('year', 'DESC')
                ->orderBy('months', 'DESC');
            // ->limit(5)
            // ->reverse()
        }

        return $res;
    }

    public function getMostBuyingItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', 'stock as qty', DB::raw('SUM(buy_price * stock) as total'))
            ->groupby('name', 'qty')
            ->orderBy('total', 'DESC');
    }

    public function getMostBuyingItemCat($_, array $args)
    {
        return DB::table('products')
            ->join("categories", "products.category_id", "=", "categories.id")
            ->select('categories.name as catName', DB::raw('SUM(products.buy_price * products.stock) as total'), DB::raw('ANY_VALUE(SUM(products.stock)) as qty'))
            ->groupby('catName')
            ->orderBy('total', 'DESC');
    }

    public function getLeastBuyingItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', 'stock as qty', DB::raw('SUM(buy_price * stock) as total'))
            ->groupby('name', 'qty')
            ->orderBy('total', 'ASC');
    }

    public function getLeastBuyingItemCat($_, array $args)
    {
        return DB::table('products')
            ->join("categories", "products.category_id", "=", "categories.id")
            ->select('categories.name as catName', DB::raw('SUM(products.buy_price * products.stock) as total'), DB::raw('ANY_VALUE(SUM(products.stock)) as qty'))
            ->groupby('catName')
            ->orderBy('total', 'ASC');
    }

    public function getTotalItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', DB::raw('SUM(stock) as qty'))
            ->groupby('name');
    }

    public function getMostItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', DB::raw('SUM(stock) as qty'))
            ->groupby('name')
            ->orderBy('qty', 'DESC');
    }

    public function getLeastItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', DB::raw('SUM(stock) as qty'))
            ->groupby('name')
            ->orderBy('qty', 'ASC');
    }

    public function getDamagedItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', DB::raw('SUM(stock) as qty'))
            ->where('is_damaged', 1)
            ->groupby('name')
            ->orderBy('qty', 'DESC');
    }

    public function getLostItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', DB::raw('SUM(stock) as qty'))
            ->where('is_lost', 1)
            ->groupby('name')
            ->orderBy('qty', 'DESC');
    }

    public function getExpiredItem($_, array $args)
    {
        return DB::table('products')
            ->select('name', DB::raw('SUM(stock) as qty'))
            ->where('is_expired', 1)
            ->groupby('name')
            ->orderBy('qty', 'DESC');
    }
}
