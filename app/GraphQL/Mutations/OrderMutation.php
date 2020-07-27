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

        for ($i=0; $i < count($args['products']); $i++) { 
            // $args['products'][$i]['qty'];
            \DB::table('order_details')->insert([
                'order_id' => $order->id,
                'product_id' => $args['products'][$i]['product_id'],
                'qty' => $args['products'][$i]['qty'],
                'price' => $args['products'][$i]['price'],
            ]);
        }

        return "success";
    }
}
