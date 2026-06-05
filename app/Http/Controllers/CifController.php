<?php

namespace App\Http\Controllers;

use App\Models\Cif;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CifController extends Controller
{
    public function index(): View
    {
        return view('cif.index');
    }

    public function list(Request $request): JsonResponse
    {
        $query = Cif::query()->select([
            'cif_id',
            'nama_lengkap',
            'email',
            'nomor_hp',
            'jenis_identitas',
            'nomor_identitas',
            'created_at',
        ]);

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('cif_id', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nomor_hp', 'like', "%{$search}%")
                    ->orWhere('nomor_identitas', 'like', "%{$search}%");
            });
        }

        $totalRecords = Cif::count();
        $filteredRecords = (clone $query)->count();

        $columns = ['cif_id', 'nama_lengkap', 'email', 'nomor_hp', 'jenis_identitas', 'nomor_identitas', 'created_at'];
        $orderColumnIndex = (int) $request->input('order.0.column', 6);
        $orderDir = $request->input('order.0.dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($columns[$orderColumnIndex] ?? 'created_at', $orderDir);

        $cifs = $query
            ->skip((int) $request->input('start', 0))
            ->take((int) $request->input('length', 10))
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $cifs->map(fn (Cif $cif) => [
                $cif->cif_id,
                e($cif->nama_lengkap),
                e($cif->email ?? '-'),
                e($cif->nomor_hp ?? '-'),
                e($cif->jenis_identitas),
                e($cif->nomor_identitas),
                $cif->created_at ? $cif->created_at->format('M d, Y') : '-',
                '<div class="flex items-center justify-end space-x-1">
                    <a href="' . route('cif.show', $cif) . '" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                </div>',
            ]),
        ]);
    }

    public function show(Cif $cif): View
    {
        $cif->load('addresses');

        return view('cif.show', compact('cif'));
    }
}
