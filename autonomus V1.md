Analisis file @MasterDb.txt.

Tugas:
1. [x] Baca struktur database SQL Server dari file tersebut.
2. [x] Buat migration Laravel yang sesuai dengan tabel, kolom, tipe data, primary key, nullable, identity/auto increment, dan default value.
3. [x] Jangan langsung overwrite file lama. Buat migration baru yang rapi. 
   - Note: Jika tipe data SQL Server tidak ada padanannya di Laravel (seperti NVARCHAR, DATETIME2), gunakan tipe data Laravel Blueprint yang paling mendekati (misal: string, dateTime).
4. [x] Setelah migration dibuat, sesuaikan fitur login agar menggunakan database baru.

Fokus login:
- Gunakan tabel users dari database baru.
- Mapping kolom untuk login:
  - user_id sebagai username/login ID (Primary Key / Unique)
  - password_hash sebagai password
  - full_name sebagai nama user
  - email sebagai email
  - role_id sebagai role
  - department_id sebagai department
  - is_active untuk validasi akun aktif
- Fitur login saat ini menggunakan API/JWT Guard (`Auth::guard('api')->attempt()`). Pertahankan arsitektur token/API guard ini namun sesuaikan isinya agar mencocokkan `user_id` (bukan email).
- Login hanya boleh berhasil jika is_active = 1.
- Sesuaikan User model (pastikan mengimplementasikan Authenticatable), Auth controller, guard/provider jika diperlukan.
- Konfigurasi Model: 
  - Set `$primaryKey = 'user_id'`. Jika `user_id` di database lama berupa string (bukan integer auto-increment), pastikan set `public $incrementing = false;` dan `protected $keyType = 'string';`.
  - Nonaktifkan timestamps (`public $timestamps = false;`) jika tabel asli tidak memiliki kolom `created_at` dan `updated_at`.
  - Tambahkan method `getAuthPassword()` di model User agar Laravel tahu password diambil dari kolom `password_hash`.
- Keamanan Password: Password di database saat ini menggunakan format Bcrypt (contoh format: $2y$12$...). Buat login logic agar tetap kompatibel dengan hash ini. Namun, berikan juga opsi atau petunjuk di komentar kode jika di kemudian hari sistem ingin di-upgrade ke Argon2id untuk keamanan yang lebih baik.

Setelah selesai:
1. Tampilkan daftar file yang dibuat/diubah.
2. Jelaskan perubahan login secara singkat.
3. Berikan command untuk menjalankan migration dan test login.
4. Jangan hapus kode lama tanpa menjelaskan alasannya (gunakan komentar kode jika ada yang di-fallback atau di-bypass).
