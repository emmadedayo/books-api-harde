<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
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
            'name' => 'Harde should choose me',
            'isbn' => '0000-000-HARDE',
            'authors' => 'Adenagbe Emmanuel, Harde Emmanuel',
            'number_of_pages' => 25,
            'publisher' => 'emmadenagbe@gmail.com',
            'country' => 'Nigeria',
            'release_date' => '2023-04-12',
        ];
    }
}
