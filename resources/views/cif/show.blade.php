@extends('layouts.app')

@section('title', 'CIF Detail')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                <a href="{{ route('cif.index') }}" class="hover:text-blue-600 transition-colors">CIF</a>
                <span>/</span>
                <span>{{ $cif->cif_id }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $cif->nama_lengkap }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $cif->jenis_identitas }} {{ $cif->nomor_identitas }}</p>
        </div>
        <a href="{{ route('cif.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-200 transition-colors">Back</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Personal Data</h2>
            <dl class="space-y-3">
                <div><dt class="text-xs text-slate-500">CIF ID</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->cif_id }}</dd></div>
                <div><dt class="text-xs text-slate-500">Name</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->nama_lengkap }}</dd></div>
                <div><dt class="text-xs text-slate-500">Birth</dt><dd class="text-sm font-medium text-slate-900">{{ trim(($cif->tempat_lahir ?? '') . ' ' . optional($cif->tanggal_lahir)->format('d M Y')) ?: '-' }}</dd></div>
                <div><dt class="text-xs text-slate-500">Nationality</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->kewarganegaraan }}</dd></div>
                <div><dt class="text-xs text-slate-500">Email</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->email ?? '-' }}</dd></div>
                <div><dt class="text-xs text-slate-500">Phone</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->nomor_hp ?? '-' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Bank Data</h2>
            <dl class="space-y-3">
                <div><dt class="text-xs text-slate-500">Bank</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->nama_bank }}</dd></div>
                <div><dt class="text-xs text-slate-500">Account Number</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->nomor_rekening }}</dd></div>
                <div><dt class="text-xs text-slate-500">Currency</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->mata_uang }}</dd></div>
                <div><dt class="text-xs text-slate-500">Account Holder</dt><dd class="text-sm font-medium text-slate-900">{{ $cif->nama_pemilik_rekening }}</dd></div>
            </dl>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Addresses</h2>
        <div class="space-y-3">
            @forelse ($cif->addresses as $address)
                <div class="border border-slate-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-900">{{ $address->address_type }}</span>
                        @if ($address->is_primary)
                            <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full px-2 py-1">Primary</span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-700">{{ $address->alamat_lengkap }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ collect([$address->kelurahan, $address->kecamatan, $address->kota_kabupaten, $address->provinsi, $address->kode_pos])->filter()->join(', ') }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No address records.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
