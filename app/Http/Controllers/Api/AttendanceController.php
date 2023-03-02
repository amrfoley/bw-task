<?php

namespace App\Http\Controllers\Api;

use App\Collections\AttendanceCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClockInRequest;
use App\Http\Responses\Api\FailedResponse;
use App\Http\Responses\Api\SuccessResponse;
use App\Services\AttendanceService;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *    title="Worker Api",
 *    version="1.0.0",
 * )
 */
class AttendanceController extends Controller
{
    /**
     * @param  protected
     * @param  protected
     */
    public function __construct(
        protected UserService $userService,
        protected AttendanceService $attendanceService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/worker/clock-ins",
     *     tags={"List clock-ins"},
     *     summary="Returns worker's clock-ins list",
     *     description="Returns list of worker clock-ins",
     *     operationId="woerker_id",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example="true"),
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $user = $this->userService->fetchfromApi($request->worker_id ?? 0);

        $attendances = $this->attendanceService->workerClockIns($user);

        return SuccessResponse::send((new AttendanceCollection($attendances))->toArray());
    }

    /**
     * @OA\Post(
     * path="/worker/clock-in",
     * summary="clock-in to work location",
     * description="Worker can clock-in the time he/she arrive to work location",
     * operationId="clockIn",
     * tags={"clockIn"},
     * @OA\RequestBody(
     *    required=true,
     *    description="clock-in params",
     *    @OA\JsonContent(
     *       required={"worker_id","timestamp","latitude","longotude"},
     *       @OA\Property(property="worker_id", type="int", example="1"),
     *       @OA\Property(property="timestamp", type="int", example="1677756960"),
     *       @OA\Property(property="latitude", type="decimal", example="30.0493558"),
     *       @OA\Property(property="longitude", type="decimal", example="31.2403066"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong data",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="boolean", example="false"),
     *       @OA\Property(
     *          property="errors", 
     *          type="array", 
     *          @OA\Items(
     *               type="object",
     *               format="query",
     *               @OA\Property(
     *                  property="message", 
     *                  type="array", 
     *                  @OA\Items(
     *                      type="string",
     *                      example="You already clocked in today!"
     *                  )
     *               ),
     *               @OA\Property(
     *                  property="worker_id", 
     *                  type="array", 
     *                  @OA\Items(
     *                      type="string",
     *                      example="The worker id field must be an integer."
     *                  )
     *               ),
     *          ),
     *        )
     *     )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="boolean", example="true")
     *        )
     *     )
     * )
     */
    public function clockIn(ClockInRequest $request)
    {
        $user = $this->userService->fetchfromApi($request->worker_id);

        if (!$this->userService->isCloseToWork($user, $request->latitude, $request->longitude)) {
            throw new FailedResponse('You are not close to work');
        }

        $attendance = $this->attendanceService->clockIn($user, $request->timestamp);

        if (!$attendance) {
            throw new FailedResponse('Failed to clock you in!');
        }

        return SuccessResponse::send();
    }
}
