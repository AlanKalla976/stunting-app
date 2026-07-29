# 04 — Bangun Fitur Inti (Tanpa Login Dulu)

Tujuan tahap ini: aplikasi bisa **dibuka dan dipakai untuk kelola data**,
tanpa perlu login sama sekali. Login ditambah belakangan di file 06. Fokus
sekarang: pastikan data balita, kriteria, dan nilai bisa dikelola dengan
benar.

## Models

```bash
php artisan make:model Balita
php artisan make:model Kriteria
php artisan make:model SubKriteria
php artisan make:model Nilai
php artisan make:model Hasil
```

```php
// app/Models/Balita.php
class Balita extends Model
{
    protected $table = 'balita';
    protected $primaryKey = 'id_balita';
    protected $fillable = ['nama_balita', 'umur', 'jenis_kelamin', 'alamat'];

    public function nilai() { return $this->hasMany(Nilai::class, 'id_balita', 'id_balita'); }
    public function hasil() { return $this->hasOne(Hasil::class, 'id_balita', 'id_balita'); }
}
```

```php
// app/Models/Kriteria.php
class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $fillable = ['nama_kriteria', 'jenis', 'bobot'];

    public function subKriteria() { return $this->hasMany(SubKriteria::class, 'id_kriteria', 'id_kriteria'); }
}
```

Buat `SubKriteria`, `Nilai`, `Hasil` mengikuti pola sama — sesuaikan
`$table`, `$primaryKey`, `$fillable` sesuai struktur di file 03.

## Controllers (CRUD Sederhana, Belum Ada Middleware)

```bash
php artisan make:controller BalitaController --resource
php artisan make:controller KriteriaController --resource
php artisan make:controller SubKriteriaController --resource
php artisan make:controller NilaiController --resource
```

Contoh `BalitaController`:

```php
class BalitaController extends Controller
{
    public function index()
    {
        $balita = Balita::latest()->paginate(10);
        return view('balita.index', compact('balita'));
    }

    public function create() { return view('balita.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'nama_balita' => 'required|string|max:100',
            'umur' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:100',
        ]);
        Balita::create($request->all());
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }

    public function edit(Balita $balitum) { return view('balita.edit', ['balita' => $balitum]); }

    public function update(Request $request, Balita $balitum)
    {
        $request->validate([
            'nama_balita' => 'required|string|max:100',
            'umur' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:100',
        ]);
        $balitum->update($request->all());
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil diperbarui');
    }

    public function destroy(Balita $balitum)
    {
        $balitum->delete();
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil dihapus');
    }
}
```

Buat pola CRUD yang sama untuk `KriteriaController`, `SubKriteriaController`.
Untuk `NilaiController`, form-nya butuh dropdown pilih balita + pilih
kriteria + isi angka nilai.

## Routes — Polos Dulu, Belum Ada Proteksi

```php
// routes/web.php
use App\Http\Controllers\{BalitaController, KriteriaController, SubKriteriaController, NilaiController};

Route::get('/', fn() => redirect('/balita'));

Route::resource('balita', BalitaController::class);
Route::resource('kriteria', KriteriaController::class);
Route::resource('sub-kriteria', SubKriteriaController::class);
Route::resource('nilai', NilaiController::class);
```

Ya, semua orang yang buka aplikasi bisa akses semua ini untuk sekarang — itu
memang sengaja, supaya Anda bisa fokus test fitur intinya dulu tanpa
terganggu urusan login. **Ini bukan versi final, cuma tahap pengembangan.**

## Views

Buat layout dasar dulu:

```
resources/views/
  layouts/app.blade.php   (navbar sederhana + @yield('content'))
  balita/index.blade.php, create.blade.php, edit.blade.php
  kriteria/index.blade.php, create.blade.php, edit.blade.php
  sub_kriteria/index.blade.php, create.blade.php, edit.blade.php
  nilai/index.blade.php, create.blade.php
```

Tidak perlu didesain cantik dulu — tabel HTML polos juga cukup untuk tahap
ini. Styling Bootstrap bisa ditambahkan belakangan setelah semua fungsi jalan.

## Checklist Sebelum Lanjut ke File 05

- [ ] Bisa tambah, lihat, edit, hapus data balita lewat browser
- [ ] Bisa tambah, lihat, edit, hapus kriteria (dengan jenis benefit/cost dan bobot)
- [ ] Bisa tambah sub kriteria yang terhubung ke kriteria induknya
- [ ] Bisa input nilai untuk kombinasi balita + kriteria
- [ ] Semua form ada validasi dasar (field wajib diisi)

Kalau semua ini sudah jalan — **baru** lanjut ke file 05 untuk bikin rumus
SAW-nya. Jangan buru-buru ke file 06 (login) sebelum bagian ini teruji.
