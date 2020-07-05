<?php

namespace App\GraphQL\Mutations;
use App\Order;

class OrderMutation
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($_, array $args)
    {
        $order = Order::create(['total' => $args['total'], 'order_date' => $args['order_date']]);

        \DB::table('order_details')->insert([
            'order_id' => $order->id,
            'product_id' => $args['product_id'],
            'qty' => $args['qty'],
            'price' => $args['price'],
        ]);

        return "success";
    }
}
