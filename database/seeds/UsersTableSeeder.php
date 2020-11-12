<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++){
            DB::table('users')->insert([ //,
                'name' => $faker->word,
                // 'phone' => $faker->unique()->numberBetween($min = 1, $max = 5),
                'email' => $faker->unique()->email,
                'password' => Hash::make('password'),
                'created_at' => Carbon\Carbon::now()
            ]);
        }
    }
}
