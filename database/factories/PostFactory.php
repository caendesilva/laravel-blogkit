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

        $user = User::all()->random();
        if (!$user->is_author) {
            $user->is_author = true; // Make sure the user becomes an author
            $user->save();
        }

        return [
            'user_id' => $user->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->sentence(),
            'body' => $this->getMarkdown(),
            'featured_image' => $this->getFeaturedImage(),
            'published_at' => rand(0, 20) < 1 ? null : $this->faker->dateTimeThisYear(),
            'tags' => $this->getTags(),
        ];
    }

    /**
     * Generate some fake markdown text for the body.
     * 
     * @return string
     */
    private function getMarkdown()
    {
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
    private function getFeaturedImage()
    {
        return "https://picsum.photos/seed/" . rand(0, 99) . "/960/640";
    }

    /**
     * Generate some tags.
     * 
     * @return array|null $tags
     */
    private function getTags()
    {
        if (!config('blog.withTags')) {
            return [];
        }

        $array = [];
        $tagcount = rand(0, rand(1, 3)); // Generate a weighted number of tags

        for ($i=0; $i < $tagcount; $i++) { 
            $words = rand(1, rand(1, rand(1, 3))); // Generate a weighted number of words in the tag
            $array[] = $this->faker->words($words, true);
        }

        return $array;
    }
}
