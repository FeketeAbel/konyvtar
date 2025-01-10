<?php

namespace Database\Factories;
 
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;
 
class BorrowingFactory extends Factory {
    public function definition() {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(), 
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
