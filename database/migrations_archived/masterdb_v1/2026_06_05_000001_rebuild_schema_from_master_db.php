<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * This migration rebuilds the tables found in MasterDb.txt.
     * Existing older migration files are left untouched; same-named tables are
     * dropped here so a database migrated from scratch matches the SQL Server dump.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (array_reverse($this->tables()) as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();

        Schema::create('cif', function (Blueprint $table) {
            $table->string('cif_id', 16)->primary();
            $table->string('nama_lengkap', 150);
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_gadis_ibu_kandung', 150)->nullable();
            $table->string('status_perkawinan', 20)->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('kewarganegaraan', 10);
            $table->string('negara_asal', 100)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('nomor_hp', 30)->nullable();
            $table->string('jenis_identitas', 30);
            $table->string('nomor_identitas', 50);
            $table->string('npwp', 16)->nullable();
            $table->string('jenis_pekerjaan', 50);
            $table->string('nama_perusahaan', 150)->nullable();
            $table->string('alamat_perusahaan', 300)->nullable();
            $table->string('bidang_usaha', 150)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('nama_bank', 100);
            $table->string('nomor_rekening', 50);
            $table->string('mata_uang', 10);
            $table->string('nama_pemilik_rekening', 150);
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('aplikasi', function (Blueprint $table) {
            $table->string('aplikasi_id', 16)->primary();
            $table->string('nomor_spaj', 50);
            $table->string('kode_plan', 50);
            $table->string('no_pemegang_polis', 16);
            $table->string('no_tertanggung', 16)->nullable();
            $table->string('no_agen', 16)->nullable();
            $table->string('tujuan_asuransi', 50)->nullable();
            $table->integer('usia_th')->nullable();
            $table->date('tanggal_mulai_pertanggungan')->nullable();
            $table->date('tanggal_akhir_pertanggungan')->nullable();
            $table->string('kode_mata_uang', 3)->nullable();
            $table->decimal('premi', 18, 2)->nullable();
            $table->decimal('nilai_kurs', 18, 2)->nullable();
            $table->integer('tenor_bulan')->nullable();
            $table->integer('frekuensi_pembayaran_bulan')->nullable();
            $table->decimal('rate_pengajuan', 18, 4)->nullable();
            $table->decimal('rate_komisi', 18, 4)->nullable();
            $table->integer('status_aplikasi')->nullable();
            $table->string('no_polis_ref', 50)->nullable();
            $table->dateTime('tgl_pengajuan')->nullable();
            $table->dateTime('tgl_dana')->nullable();
            $table->dateTime('tgl_underwrite')->nullable();
            $table->string('catatan_underwrite', 100)->nullable();
            $table->string('user_underwrite', 100)->nullable();
        });

        Schema::create('aplikasi_ahli_waris', function (Blueprint $table) {
            $table->bigIncrements('aplikasi_ahli_waris_id');
            $table->string('aplikasi_id', 16);
            $table->string('cif_id', 16);
            $table->integer('no_urut');
            $table->decimal('persentase', 5, 2);
            $table->dateTime('created_at')->useCurrent();
        });

        Schema::create('aplikasi_cif', function (Blueprint $table) {
            $table->bigIncrements('aplikasi_cif_id');
            $table->string('aplikasi_id', 16);
            $table->string('cif_id', 16);
            $table->string('nama_lengkap', 150);
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_gadis_ibu_kandung', 150)->nullable();
            $table->string('status_perkawinan', 20)->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('kewarganegaraan', 10);
            $table->string('negara_asal', 100)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('nomor_hp', 30)->nullable();
            $table->string('jenis_identitas', 30);
            $table->string('nomor_identitas', 50);
            $table->string('npwp', 16)->nullable();
            $table->string('jenis_pekerjaan', 50);
            $table->string('nama_perusahaan', 150)->nullable();
            $table->string('alamat_perusahaan', 300)->nullable();
            $table->string('bidang_usaha', 150)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('nama_bank', 100);
            $table->string('nomor_rekening', 50);
            $table->string('mata_uang', 10);
            $table->string('nama_pemilik_rekening', 150);
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('aplikasi_cif_address', function (Blueprint $table) {
            $table->bigIncrements('aplikasi_cif_id');
            $table->string('aplikasi_id', 16);
            $table->string('cif_id', 16);
            $table->string('address_type', 20);
            $table->boolean('is_primary');
            $table->string('alamat_lengkap', 255);
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kota_kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('negara', 100)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('aplikasi_document', function (Blueprint $table) {
            $table->bigIncrements('document_aplikasi_id');
            $table->string('aplikasi_id', 16);
            $table->string('document_type', 50);
            $table->string('document_name', 150);
            $table->string('file_path', 500);
            $table->string('file_extension', 10);
            $table->integer('file_size_kb')->nullable();
            $table->string('uploaded_by', 100);
            $table->dateTime('uploaded_at')->useCurrent();
            $table->string('remarks', 255)->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('cif_address', function (Blueprint $table) {
            $table->increments('address_id');
            $table->string('cif_id', 16);
            $table->string('address_type', 20);
            $table->boolean('is_primary')->default(false);
            $table->string('alamat_lengkap', 255);
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kota_kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('negara', 100)->nullable()->default('indonesia');
            $table->string('no_telp', 20)->nullable();
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->index('cif_id', 'idx_cif_address_cif');
            // SQL Server used a filtered unique index where is_primary = 1.
            // Laravel Blueprint/MySQL has no portable partial-unique equivalent,
            // so this preserves the lookup index without over-constraining data.
            $table->index(['cif_id', 'address_type'], 'ux_cif_address_primary');
        });

        Schema::create('cif_family', function (Blueprint $table) {
            $table->increments('family_id');
            $table->string('cif_id_utama', 16);
            $table->string('cif_id_keluarga', 16);
            $table->string('hubungan_keluarga', 30);
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['cif_id_utama', 'cif_id_keluarga'], 'uq_family');
        });

        Schema::create('cif_pajak_wna', function (Blueprint $table) {
            $table->increments('pajak_id');
            $table->string('cif_id', 16);
            $table->string('jenis_pajak', 30);
            $table->string('nomor_pajak', 50);
            $table->string('negara_pajak', 100)->nullable();
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('code', 50)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->unique('code');
        });

        Schema::create('kurs_harian', function (Blueprint $table) {
            $table->bigIncrements('kurs_harian_id');
            $table->date('kurs_date');
            $table->string('currency_code', 3);
            $table->decimal('kurs_beli', 18, 6);
            $table->decimal('kurs_jual', 18, 6);
            $table->boolean('is_active')->default(true);
            $table->string('created_by', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->unique(['kurs_date', 'currency_code'], 'UQ_kurs_harian_date_currency');
        });

        Schema::create('master_lookup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_code', 50);
            $table->string('code', 50);
            $table->string('name', 100);
            $table->string('value', 100)->nullable();
            $table->integer('sequence')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->string('description', 255)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->unique(['group_code', 'code'], 'ux_master_lookup');
        });

        Schema::create('master_negara', function (Blueprint $table) {
            $table->bigIncrements('country_id');
            $table->char('kd_iso3', 3);
            $table->char('kd_iso2', 2);
            $table->char('kd_iso_num', 3);
            $table->string('nama_negara', 150);
            $table->boolean('is_active')->nullable()->default(true);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->unique('kd_iso2', 'ux_country_iso2');
            $table->unique('kd_iso3', 'ux_country_iso3');
            $table->unique('kd_iso_num', 'ux_country_isonum');
        });

        Schema::create('master_produk', function (Blueprint $table) {
            $table->string('kode_produk', 20)->primary();
            $table->string('nama_produk', 100);
            $table->char('kode_mata_uang', 3);
            $table->string('no_rekening_penerima', 20)->nullable();
            $table->decimal('premi_min', 18, 2)->nullable();
            $table->decimal('premi_max', 18, 2)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->string('status', 10)->default('AKTIF');
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('master_produk_plan', function (Blueprint $table) {
            $table->string('kode_produk', 20);
            $table->string('kode_plan', 30);
            $table->string('nama_plan', 100);
            $table->integer('frekuensi_pembayaran_bulan');
            $table->integer('tenor_bulan');
            $table->char('butuh_konfirmasi_cair', 1)->default('Y');
            $table->integer('batas_konfirmasi_hari')->default(7);
            $table->string('keterangan', 255)->nullable();
            $table->string('status', 10)->nullable()->default('AKTIF');
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->primary(['kode_produk', 'kode_plan']);
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('name', 100);
            $table->string('code', 100);
            $table->string('url', 255)->nullable();
            $table->string('controller', 50)->nullable();
            $table->string('action', 50)->nullable();
            $table->integer('param')->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer('sort_order')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->string('menu_type', 20)->nullable();
            $table->string('stored_procedure', 200)->nullable();
            $table->text('params_json')->nullable();
            $table->unique('code');
        });

        Schema::create('polis', function (Blueprint $table) {
            $table->string('no_polis', 30)->primary();
            $table->string('aplikasi_id', 16);
            $table->dateTime('tgl_exit')->nullable();
            $table->integer('status_polis');
            $table->dateTime('tgl_cetak')->nullable();
            $table->dateTime('tgl_convert')->nullable();
            $table->string('user_convert', 100)->nullable();
            $table->decimal('nailai_up_max', 18, 2)->nullable();
            $table->index('aplikasi_id', 'idx_polis_aplikasi');
            $table->index('status_polis', 'idx_polis_status');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('level_role')->nullable();
            $table->string('description', 255)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
        });

        Schema::create('role_department_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('department_id');
            $table->integer('menu_id');
            $table->boolean('is_access')->nullable()->default(true);
            $table->unique(['role_id', 'department_id', 'menu_id'], 'uq_role_dept_menu');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 50)->primary();
            $table->integer('department_id');
            $table->integer('role_id');
            $table->string('password_hash', 255);
            $table->string('full_name', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->boolean('is_active')->default(true);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->dateTime('password_expiry_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (array_reverse($this->tables()) as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @return array<int, string>
     */
    private function tables(): array
    {
        return [
            'cif',
            'aplikasi',
            'aplikasi_ahli_waris',
            'aplikasi_cif',
            'aplikasi_cif_address',
            'aplikasi_document',
            'cif_address',
            'cif_family',
            'cif_pajak_wna',
            'departments',
            'kurs_harian',
            'master_lookup',
            'master_negara',
            'master_produk',
            'master_produk_plan',
            'menus',
            'polis',
            'roles',
            'role_department_menu',
            'users',
            // Legacy tables from the original Laravel schema. They are not part
            // of MasterDb.txt and may still hold foreign keys to users.id.
            'policy_riders',
            'documents',
            'tasks',
            'appointments',
            'policies',
            'customer_dependents',
            'customer_addresses',
            'customers',
            'agents',
            'password_reset_tokens',
            'appointment_status',
            'task_status',
            'source_type',
            'gender',
            'title',
            'marital_status',
            'suffix',
            'preferred_contact',
            'preferred_language',
            'address_type',
            'license_status',
            'license_type',
            'carrier',
            'policy_status',
            'policy_type',
            'payment_mode',
            'relationship',
            'state',
            'lead_source',
        ];
    }
};
