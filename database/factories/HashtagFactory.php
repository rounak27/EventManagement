<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hashtag>
 */
class HashtagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $eventId = Event::inRandomOrder()->first()->id;

        return [
            'name' => fake()->unique()->word, // Generate unique words as hashtag names
            'event_id' => $eventId

        ];
    }
}
