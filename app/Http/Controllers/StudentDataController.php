<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentDataController extends Controller
{
    // ==============================
    // INDEX (TAMPILAN UTAMA)
    // ==============================
    public function index(Request $request)
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        $search = $request->get('search');
        $prodi = $request->get('prodi');
        $tahun = $request->get('tahun'); // ubah dari 'angkatan' ke 'tahun'

        $query = User::query()->where('role', '!=', 'admin');

        // 🔍 Filter pencarian nama / NIM
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%');
            });
        }

        // 🏫 Filter berdasarkan prodi
        if ($prodi && $prodi !== 'Semua Program Studi') {
            $query->where('prodi', $prodi);
        }


        // 🎓 Filter berdasarkan tahun (angkatan)
        if ($tahun && $tahun !== 'Semua Tahun') {
    $query->where('angkatan', $tahun);

            // Jika kamu belum punya kolom "angkatan" tapi mau pakai NIM:
            // $query->whereRaw('LEFT(nim, 2) = ?', [substr($tahun, 2)]);
        }

        // 🔹 Ambil data dan kirim ke view
        $mahasiswas = $query->orderBy('name', 'asc')->paginate(10);

        $daftarProdi = [
            'Semua Program Studi',
            'D3 Teknik Otomotif',
            'D3 Teknik Informatika',
            'D3 Budidaya Tanaman Perkebunan',
            'D4 Bisnis Digital',
            'D4 Akuntansi Bisnis Digital',
            'D4 Manajemen Pemasaran Internasional',
            'D4 Teknologi Rekayasa Multimedia',
        ];

        $daftarTahun = array_merge(['Semua Tahun'], range(2020, now()->year));


        return view('student_data.index', compact('mahasiswas', 'daftarProdi', 'daftarTahun'));
    }

    $filterAngkatan = null;
    return view('student_data.index', compact('filterAngkatan'));
}


    // ==============================
    // FORM EDIT DATA DIRI
    // ==============================
   public function edit($id = null)
    {
        $auth = auth()->user();

        if ($id) {
            // hanya admin boleh edit user lain
            if ($auth->role !== 'admin') {
                abort(403, 'Akses ditolak');
            }
            $user = User::findOrFail($id);
        } else {
            $user = $auth;
        }

        $daftarProdi = [
            'D3 Teknik Otomotif',
            'D3 Teknik Informatika',
            'D3 Budidaya Tanaman Perkebunan',
            'D4 Bisnis Digital',
            'D4 Akuntansi Bisnis Digital',
            'D4 Manajemen Pemasaran Internasional',
            'D4 Teknologi Rekayasa Multimedia',
        ];

        $daftarTahun = range(2020, now()->year);

        return view('student_data.edit', compact('user', 'daftarProdi', 'daftarTahun'));
    }

    // ==============================
    // UPDATE DATA DIRI
    // ==============================
    public function update(Request $request, $id)
    {
        $auth = auth()->user();

        // hanya admin boleh mengupdate data mahasiswa lain
        if ($auth->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'nim' => 'nullable|string|max:20',
            'email' => 'required|email',
            'prodi' => 'nullable|string|max:191',
            'role' => 'nullable|in:user,alumni', // hanya izinkan user atau alumni
        ]);

        // Ambil 2 digit pertama NIM untuk angkatan (contoh: 23 → 2023)
        $angkatan = null;
        if (!empty($request->nim) && strlen($request->nim) >= 2) {
            $angkatan = '20' . substr($request->nim, 0, 2);
        }
        $roleBefore = $user->role;

        $updateData = [
            'name' => $request->name,
            'nim' => $request->nim,
            'angkatan' => $angkatan,
            'email' => $request->email,
            'prodi' => $request->prodi,
        ];

        // Cek jika role berubah menjadi alumni
       
        if ($request->filled('role')) {
            $updateData['role'] = $request->role;
    }

        $user->update($updateData);

        // ==============================
// LOGIKA PINDAH KE ALUMNI OTOMATIS
// ==============================
if ($roleBefore !== 'alumni' && $request->role === 'alumni') {

    // Ambil data mahasiswa terkait user
    $mahasiswaData = \App\Models\MahasiswaData::where('user_id', $user->id)->first();

    if ($mahasiswaData) {

        // Cek apakah data alumni sudah ada
        $existingAlumni = \App\Models\AlumniData::where('user_id', $user->id)->first();

        if (!$existingAlumni) {

            // Ambil angkatan dari MahasiswaData, jika kosong coba dari NIM user
            $graduation_year = $mahasiswaData->angkatan;
            if (empty($graduation_year) && !empty($user->nim) && strlen($user->nim) >= 2) {
                $graduation_year = '20' . substr($user->nim, 0, 2);
            }

            // Buat data alumni
            \App\Models\AlumniData::create([
                'user_id' => $user->id,
                'graduation_year' => $graduation_year,
                'phone_number' => null,
                'current_address' => null,
                'employment_status' => null,
                'company_name' => null,
                'position' => null,
                'work_address' => null,
                'industry_field' => null,
                'workplace_photo_path' => null,
                'deskripsi' => null,
                'bidang_industri' => null,
            ]);

            // Opsional: hapus data mahasiswa agar tidak double
            $mahasiswaData->delete();
        }
    } else {
        // Kalau MahasiswaData tidak ditemukan, buat alumni tetap dari data user
        $graduation_year = !empty($user->nim) && strlen($user->nim) >= 2 ? '20' . substr($user->nim, 0, 2) : null;

        $existingAlumni = \App\Models\AlumniData::where('user_id', $user->id)->first();
        if (!$existingAlumni) {
            \App\Models\AlumniData::create([
                'user_id' => $user->id,
                'graduation_year' => $graduation_year,
                'phone_number' => null,
                'current_address' => null,
                'employment_status' => null,
                'company_name' => null,
                'position' => null,
                'work_address' => null,
                'industry_field' => null,
                'workplace_photo_path' => null,
                'deskripsi' => null,
                'bidang_industri' => null,
            ]);
        }
    }

    // Pastikan role user tetap di-update
    $user->role = 'alumni';
    $user->save();

        // Hapus semua data mahasiswa terkait user
\App\Models\MahasiswaData::where('user_id', $user->id)->delete();

}

        return redirect()->route('student_data.index')->with('success', 'Data berhasil diperbarui!');
    }


    public function show($id)
{
    $mahasiswa = User::findOrFail($id);

    // Kalau yang login bukan admin, larang akses data orang lain
    if (auth()->user()->role !== 'admin' && auth()->id() !== $mahasiswa->id) {
        abort(403, 'Akses ditolak');
    }

    return view('student_data.show', compact('mahasiswa'));
}

}
