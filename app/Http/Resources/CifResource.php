<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CifResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'cif_id' => $this->cif_id,
            'route_key' => $this->getRouteKey(),
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => optional($this->tanggal_lahir)->toDateString(),
            'kewarganegaraan' => $this->kewarganegaraan,
            'email' => $this->email,
            'nomor_hp' => $this->nomor_hp,
            'jenis_identitas' => $this->jenis_identitas,
            'nomor_identitas' => $this->nomor_identitas,
            'jenis_pekerjaan' => $this->jenis_pekerjaan,
            'nama_bank' => $this->nama_bank,
            'nomor_rekening' => $this->nomor_rekening,
            'mata_uang' => $this->mata_uang,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
