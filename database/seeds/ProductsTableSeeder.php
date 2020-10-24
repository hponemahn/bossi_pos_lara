<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 30; $i++){
            DB::table('products')->insert([ //,
                'name' => "ut",
                'category_id' => 2,
                'stock' => 50,
                'buy_price' => 2000,
                'sell_price' => 6000,
                'discount_price' => 5000,
                'sku' => $faker->word,
                'created_at' => Carbon\Carbon::now()
            ]);
        }
    }
}
