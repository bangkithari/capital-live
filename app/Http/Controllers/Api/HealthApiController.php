<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

/**
 * Health API Controller
 *
 * Public service health check endpoint.
 */
#[Group('Health')]
class HealthApiController extends Controller
{
    /**
     * Health check
     *
     * Return the API status, version, and current server timestamp.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'version' => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
