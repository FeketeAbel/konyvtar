<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
 
class BookFactory extends Factory {
    public function definition() {
        return [
            'title' => $this->faker->sentence(3), 
            'author' => $this->faker->name,
            'category_id' => Category::factory(), 
            'available' => $this->faker->boolean(80), 
        ];
    }
}