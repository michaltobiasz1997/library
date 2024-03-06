<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(2),
            'author' => $this->faker->name(),
            'year' => $this->faker->year(),
            'publisher' => $this->faker->company(),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Book $book) {
            if ($this->faker->boolean(70)) {
                $randomCustomer = Customer::all()->random();
                $randomReturnedAt = $this->faker->randomElement([
                    null, $this->faker->dateTimeBetween('now', '+1 year')
                ]);

                $book->customerHistory()->attach(
                    id: $randomCustomer->id,
                    attributes: ['returned_at' => $randomReturnedAt],
                );

                if (null === $randomReturnedAt) {
                    $book->customer()->associate($randomCustomer);
                    $book->save();
                }
            }
        });
    }
}
