<?php

namespace Database\Factories;

use App\Enums\WorkPlaceStatus;
use App\Enums\WorkPlaceType;
use App\Models\WorkPlace;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkPlace>
 */
class WorkPlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkPlace::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => fake()->name(),
            'slug'      => fake()->unique()->slug(16),
            'type'      => fake()->randomElement(array_column(WorkPlaceType::cases(), 'value')),
            'active'    => fake()->boolean(90),
            'status'    => fake()->randomElement(array_column(WorkPlaceStatus::cases(), 'value')),
            'lat'       => fake()->latitude(30.0493550, 30.049360),
            'long'      => fake()->longitude(31.2403060, 31.2403070),
        ];
    }
}
