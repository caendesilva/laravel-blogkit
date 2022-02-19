<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'user_id' => User::pluck('id')->random(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->sentence(),
            'body' => $this->getMarkdown(),
            'featured_image' => $this->getFeaturedImage(),
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    /**
     * Generate some fake markdown text for the body.
     * 
     * @return string
     */
    private function getMarkdown() {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($faker));

        return $faker->markdown();
    }

    /**
     * Generate a seed and use picsum.photos to get a random image.
     * @see https://picsum.photos/
     * 
     * @return string
     */
    private function getFeaturedImage() {
        return "https://picsum.photos/seed/" . rand(0, 99) . "/640/320";
    }
}
