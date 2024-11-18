<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $types = ['mammal', 'bird', 'reptile', 'amphibian', 'fish', 'invertebrate'];
        $animals = [
            'mammal' => ['cat', 'dog', 'elephant', 'giraffe', 'hippopotamus', 'kangaroo', 'koala', 'lion', 'panda', 'penguin', 'rabbit', 'red panda', 'sloth', 'tiger', 'wolf'],
            'bird' => ['albatross', 'blue jay', 'cardinal', 'chicken', 'crow', 'duck', 'eagle', 'flamingo', 'goose', 'hawk', 'hummingbird', 'kiwi', 'ostrich', 'owl', 'parrot', 'peacock', 'pelican', 'penguin', 'pigeon', 'robin', 'sparrow', 'swan', 'turkey', 'vulture', 'woodpecker'],
            'reptile' => ['alligator', 'anaconda', 'boa', 'chameleon', 'cobra', 'crocodile', 'gecko', 'iguana', 'komodo dragon', 'python', 'rattlesnake', 'sea turtle', 'snapping turtle', 'tortoise'],
            'amphibian' => ['bullfrog', 'newt', 'salamander', 'toad'],
            'fish' => ['bass', 'catfish', 'clownfish', 'goldfish', 'guppy', 'mackerel', 'salmon', 'shark', 'stingray', 'swordfish', 'trout', 'tuna'],
            'invertebrate' => ['ant', 'bee', 'beetle', 'butterfly', 'caterpillar', 'centipede', 'cockroach', 'crab', 'dragonfly', 'earthworm', 'fly', 'grasshopper', 'jellyfish', 'ladybug', 'lobster', 'millipede', 'mosquito', 'octopus', 'scorpion', 'snail', 'spider', 'squid', 'tarantula', 'wasp']
        ];

        $randomType = $this->faker->randomElement($types);
        $randomAnimal = $this->faker->randomElement($animals[$randomType]);

        return [
            'name' => $randomAnimal,
            'type' => $randomType,
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'jump_height' => $this->faker->numberBetween(0, 3000),
        ];
    }


}