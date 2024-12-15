<?php

namespace Database\Factories;

use App\Models\Animal; // Import the Animal model
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = ['fox', 'dog', 'kangaroo', 'penguin', 'rabbit', 'snail', 'chicken'];
        $types = ['mammal', 'bird', 'rodent'];
        $animals = [
            'mammal' => ['fox', 'dog', 'kangaroo', 'penguin', 'rabbit', 'snail'],
            'bird' => ['chicken'],
            'rodent' => ['kangaroo'],
        ];

        $randomType = $this->faker->randomElement($types);
        $randomAnimal = $this->faker->randomElement($animals[$randomType]);

        // Use Faker's unique modifier to ensure uniqueness for slug
        $randomSlug = $this->faker->unique()->randomElement($slug);

        return [
            'slug' => $randomSlug,
            'name' => $randomAnimal,
            'type' => $randomType,
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'jump_height' => $this->faker->numberBetween(0, 150),
        ];
    }
}