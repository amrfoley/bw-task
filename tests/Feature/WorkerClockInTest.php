<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkPlace;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerClockInTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $lat, $long, $workPlace;

    public function setUp(): void
    {
        parent::setUp();
        $this->lat = $this->faker->latitude();
        $this->long = $this->faker->longitude();
        $this->workPlace = WorkPlace::factory()
            ->hasWorkers(1)
            ->create(['lat' => $this->lat, 'long' => $this->long]);
    }

    public function test_worker_can_clock_in(): void
    {
        $data = [
            'worker_id' => $this->workPlace->Workers->first()->id,
            'timestamp' => Carbon::now()->timestamp,
            'latitude'  => $this->lat,
            'longitude' => $this->long,
        ];

        $this->post(route('attendance.clockIn'), $data)
            ->assertJson(['status' => true])
            ->assertStatus(200);
    }

    public function test_worker_can_not_clock_in_from_distance_place(): void
    {
        $data = [
            'worker_id' => $this->workPlace->Workers->first()->id,
            'timestamp' => Carbon::now()->timestamp,
            'latitude'  => (float) $this->lat + 50,
            'longitude' => (float) $this->long + 50,
        ];

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['message' => ['You are not close to work']]);
    }
}
