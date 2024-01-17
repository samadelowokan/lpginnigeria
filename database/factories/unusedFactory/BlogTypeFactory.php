<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->word();
        $slug = Str::slug($title, '-');

        return [
            'bt_name' => $title, //Generates a fake sentence
            'slug' => $slug,
            'bt_desc' => $this->faker->sentence(1), //generates fake 3 sentences

        ];
    }
}
