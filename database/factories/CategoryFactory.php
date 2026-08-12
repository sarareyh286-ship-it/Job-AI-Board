<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * ربط الـ Factory بشكل صريح بـ Category Model
     */
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Software Engineering',
                'Web Development',
                'Mobile App Development',
                'UI/UX Design',
                'Data Science & AI',
                'Cyber Security'
            ]),
            'description' => fake()->sentence(),
        ];
    }
}