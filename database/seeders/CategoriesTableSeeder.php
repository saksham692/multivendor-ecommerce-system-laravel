<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Generate 100 fake category entries
        for ($i = 0; $i < 100; $i++) {
            DB::table('categories')->insert([
                'parent_id' => $faker->optional()->randomElement([null, $faker->numberBetween(1, 50)]),
                'name' => $name = $faker->unique()->words(2, true),
                'slug' => Str::slug($name),
                'icon' => $faker->optional()->randomElement(['fa-star', 'fa-heart', 'fa-circle']),
                'description' => $faker->optional()->sentence(),
                'thumbnail_img' => $faker->optional()->imageUrl(),
                'publish' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
