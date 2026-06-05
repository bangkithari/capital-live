<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard API Controller
 *
 * Retrieve dashboard statistics and summary data.
 * Returns counts for CIF, polis, aplikasi, and users.
 */
#[Group('Dashboard')]
class DashboardApiController extends Controller
{
    /**
     * Get dashboard statistics
     *
     * Returns real-time counts of all major entities in the system.
     * Useful for building dashboard widgets and summary cards.
     */
    public function index(): JsonResponse
    {
        $stats = [
            'cif' => $this->safeCount('cif'),
            'polis' => $this->safeCount('polis'),
            'aplikasi' => $this->safeCount('aplikasi'),
            'users' => $this->safeCount('users'),
        ];

        return response()->json([
            'data' => $stats,
            'generated_at' => now()->toIso8601String(),
        ]);
    }

    private function safeCount(string $table): int
    {
        try {
            return DB::table($table)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
