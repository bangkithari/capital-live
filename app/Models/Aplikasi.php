<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $aplikasi_id
 * @property string $nomor_spaj
 * @property string $kode_plan
 * @property string $no_pemegang_polis
 * @property string|null $no_tertanggung
 * @property string|null $no_agen
 * @property string|null $tujuan_asuransi
 * @property int|null $usia_th
 * @property \Illuminate\Support\Carbon|null $tanggal_mulai_pertanggungan
 * @property \Illuminate\Support\Carbon|null $tanggal_akhir_pertanggungan
 * @property string|null $kode_mata_uang
 * @property numeric|null $premi
 * @property numeric|null $nilai_kurs
 * @property int|null $tenor_bulan
 * @property int|null $frekuensi_pembayaran_bulan
 * @property numeric|null $rate_pengajuan
 * @property numeric|null $rate_komisi
 * @property int|null $status_aplikasi
 * @property string|null $no_polis_ref
 * @property \Illuminate\Support\Carbon|null $tgl_pengajuan
 * @property \Illuminate\Support\Carbon|null $tgl_dana
 * @property \Illuminate\Support\Carbon|null $tgl_underwrite
 * @property string|null $catatan_underwrite
 * @property string|null $user_underwrite
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereAplikasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereCatatanUnderwrite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereFrekuensiPembayaranBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereKodeMataUang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereKodePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereNilaiKurs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereNoAgen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereNoPemegangPolis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereNoPolisRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereNoTertanggung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereNomorSpaj($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi wherePremi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereRateKomisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereRatePengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereStatusAplikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTanggalAkhirPertanggungan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTanggalMulaiPertanggungan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTenorBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTglDana($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTglPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTglUnderwrite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereTujuanAsuransi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereUserUnderwrite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aplikasi whereUsiaTh($value)
 * @mixin \Eloquent
 */
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
