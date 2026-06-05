<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CifResource;
use App\Models\Cif;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('CIF')]
class CifApiController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Cif::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('cif_id', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nomor_hp', 'like', "%{$search}%")
                    ->orWhere('nomor_identitas', 'like', "%{$search}%");
            });
        }

        return CifResource::collection(
            $query->orderBy('created_at', 'desc')->paginate($request->integer('per_page', 15))
        );
    }

    public function show(Cif $cif): CifResource
    {
        return new CifResource($cif);
    }
}
