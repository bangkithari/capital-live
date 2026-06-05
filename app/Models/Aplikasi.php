<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    protected $table = 'aplikasi';

    protected $primaryKey = 'aplikasi_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'tanggal_mulai_pertanggungan' => 'date',
        'tanggal_akhir_pertanggungan' => 'date',
        'premi' => 'decimal:2',
        'nilai_kurs' => 'decimal:2',
        'rate_pengajuan' => 'decimal:4',
        'rate_komisi' => 'decimal:4',
        'tgl_pengajuan' => 'datetime',
        'tgl_dana' => 'datetime',
        'tgl_underwrite' => 'datetime',
    ];
}
