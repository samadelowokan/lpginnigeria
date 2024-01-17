<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BlogType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $slug = Str::slug($title, '-');

        return [
            'user_id' => User::factory(), //Generates a User from factory and extracts id
            'blog_type_id' => BlogType::factory(), //Generates a Blog Type from factory and extracts id
            'title' => $title, //Generates a fake sentence
            'slug' => $slug,
            'img_url' => 'image-3.png', //generates fake 1 paragraphs
            'body' => $this->faker->paragraph(10) //generates fake 10 paragraphs
        ];
    }
}
