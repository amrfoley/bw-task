<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerClockInRequestTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    public function test_worker_id_is_required_and_int(): void
    {
        $data = [
            'timestamp' => Carbon::now()->timestamp,
            'latitude'  => $this->faker->latitude(),
            'longitude'  => $this->faker->longitude(),
        ];

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['worker_id' => ['The worker id field is required.']]);

        $data['worker_id'] = $this->faker->word();

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['worker_id' => ['The worker id field must be an integer.']]);
    }

    public function test_timestamp_is_required_and_valid(): void
    {
        $data = [
            'worker_id' => 1,
            'latitude'  => $this->faker->latitude(),
            'longitude'  => $this->faker->longitude(),
        ];

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['timestamp' => ['The timestamp field is required.']]);

        $data['timestamp'] = Carbon::now()->addHour()->timestamp;

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['timestamp' => ['The timestamp is not a valid!']]);
    }

    public function test_longitude_is_required(): void
    {
        $data = [
            'worker_id'  => 1,
            'timestamp' => Carbon::now()->timestamp,
            'latitude'  => $this->faker->latitude(),
        ];

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['longitude' => ['The longitude field is required.']]);
    }

    public function test_latitude_is_required(): void
    {
        $data = [
            'worker_id'  => 1,
            'timestamp' => Carbon::now()->timestamp,
            'longitude'  => $this->faker->longitude(),
        ];

        $this->post(route('attendance.clockIn'), $data)
            ->assertStatus(422)
            ->assertJson(['status' => false])
            ->assertJsonValidationErrors(['latitude' => ['The latitude field is required.']]);

        $data['worker_id'] = $this->faker->word();
    }
}
