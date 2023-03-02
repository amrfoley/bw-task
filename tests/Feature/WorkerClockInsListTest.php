<?php

namespace Tests\Feature;

use App\Models\WorkPlace;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerClockInsListTest extends TestCase
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

    public function test_worker_can_list_clock_ins(): void
    {
        $time = Carbon::now()->timestamp;

        $data = [
            'worker_id' => $this->workPlace->Workers->first()->id,
            'timestamp' => $time,
            'latitude'  => $this->lat,
            'longitude' => $this->long,
        ];

        $this->post(route('attendance.clockIn'), $data);

        $this->call('get', route('attendance.index'), ['worker_id' => $this->workPlace->workers->first()->id])
            ->assertStatus(200)
            ->assertJson(['status' => true, 'data' => [['clock-in' => Carbon::parse($time)->format('d M Y H:i:s')]]]);
    }
}