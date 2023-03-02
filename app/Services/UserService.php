<?php

namespace App\Services;

use App\Http\Responses\Api\FailedResponse;
use App\Models\Attendance;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function fetchfromApi(int $userId)
    {
        $user = $this->userRepository->findWith(['id' => $userId], ['workPlace']);

        if ($user->count() === 0) {
            throw new FailedResponse('Worker not found!', 404);
        }

        return $user->first();
    }

    /**
     * @param User $user
     * @param float $lat
     * @param float $long
     * 
     * @return bool
     */
    public function isCloseToWork(User $user, float $lat, float $long): bool
    {
        $workPlaceLat = $user->workPlace->lat;
        $workPlaceLong = $user->workPlace->long;
        $dLat = deg2rad($lat - $workPlaceLat);
        $dLon = deg2rad($long - $workPlaceLong);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($workPlaceLat)) * cos(deg2rad($lat)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = 6371 * $c; // Distance in km

        return $distance <= Attendance::ALLOWED_RADIUS;
    }
}
