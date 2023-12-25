<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Article>
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
            'title'     => fake()->sentence(1),
            'content'   => fake()->paragraph(5),
            'excerpt'   => fake()->paragraph(1),
            'meta_data' => implode(",", fake()->randomElements(['news', 'arabic', 'english'], 2)),
            'approved'  => random_int(0, 1),
            'user_id'   => \App\Models\User::all()->random(1)->first()->id,
        ];
    }
}
