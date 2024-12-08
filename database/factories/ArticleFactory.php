<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text,
            'keywords' => $this->faker->words(5, true),
            'image_url' => $this->faker->imageUrl,
            'published_at' => $this->faker->dateTimeBetween('this year', 'now'),
            'source_id' => Source::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
            'author_id' => Author::inRandomOrder()->value('id'),
        ];
    }
}
