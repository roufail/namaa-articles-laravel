<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'      => fake()->sentence(1),
            'content'    => fake()->paragraph(5),
            'approved'   => random_int(0, 1),
            'user_id'    => \App\Models\User::all()->random(1)->first()->id,
            'article_id' => \App\Models\Admin\Article::all()->random(1)->first()->id,
        ];
    }
}
