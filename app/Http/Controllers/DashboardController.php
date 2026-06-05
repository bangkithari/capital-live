<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'cif' => $this->safeCount('cif'),
            'polis' => $this->safeCount('polis'),
            'aplikasi' => $this->safeCount('aplikasi'),
            'users' => $this->safeCount('users'),
        ];

        return view('dashboard', compact('stats'));
    }

    /**
     * Count records safely, returning 0 if table doesn't exist
     */
    private function safeCount(string $table): int
    {
        try {
            return DB::table($table)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
