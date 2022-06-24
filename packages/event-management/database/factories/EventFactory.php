<?php

namespace OpenSynergic\EventManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use OpenSynergic\EventManagement\Models\Event;

class EventFactory extends Factory
{
  protected $model = Event::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name' => [
        'en' => $this->faker->words(3, true)
      ],
      'date' => $this->faker->date(),
      'time' => $this->faker->time(),
      'type' => $this->faker->randomElement(['OFFLINE', 'ONLINE']),
      'status' => $this->faker->randomElement(['DRAFT', 'PUBLISHED', 'ARCHIVED']),
      // 'updated_at' => now(),
      // 'created_at' => now(),
    ];
  }
}
