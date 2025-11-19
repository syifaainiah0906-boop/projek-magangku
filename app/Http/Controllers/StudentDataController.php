<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MahasiswaData;
use App\Models\AlumniData;

class StudentDataController extends Controller
{
    // ==============================
    // INDEX (TAMPILAN UTAMA)
    // ==============================
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $search = $request->get('search');
            $prodi  = $request->get('prodi');
            $tahun  = $request->get('tahun');

            // Query utama ambil data mahasiswa aktif (user)
            $query = User::where('role', 'user')
                ->with('mahasiswaData');

            // Filter pencarian
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswaData', function ($sub) use ($search) {
                        $sub->where('nim', 'like', "%{$search}%");
                    });
                });
            }

            // Filter Prodi
            if (!empty($prodi) && $prodi !== 'Semua Program Studi') {
                $query->whereHas('mahasiswaData', function ($q) use ($prodi) {
                    $q->where('prodi', $prodi);
                });
            }

            // Filter Tahun
            if (!empty($tahun) && $tahun !== 'Semua Tahun') {
                $query->whereHas('mahasiswaData', function ($q) use ($tahun) {
                    $q->where('angkatan', $tahun);
                });
            }

            // Ambil hasil
            $mahasiswas = $query->orderBy('name', 'asc')->paginate(10);

            // Dropdown prodi
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

        // Untuk user biasa
        $filterAngkatan = null;
        return view('student_data.index', compact('filterAngkatan'));
    }

    // ==============================
    // FORM EDIT DATA
    // ==============================
    public function edit($id)
    {
        $mahasiswa = User::findOrFail($id);

        if (auth()->user()->role !== 'admin' && auth()->id() !== $mahasiswa->id) {
            abort(403, 'Akses ditolak');
        }

        return view('student_data.edit', compact('mahasiswa'));
    }

    // ==============================
    // UPDATE DATA (UBAH ROLE)
    // ==============================
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        $user = User::findOrFail($id);
        $roleBefore = $user->role;

        $request->validate([
            'name'  => 'required|string|max:100',
            'nim'   => 'nullable|string|max:20',
            'email' => 'required|email',
            'prodi' => 'nullable|string|max:191',
            'role'  => 'nullable|in:user,alumni',
        ]);

        // Angkatan dari NIM
        $angkatan = null;
        if (!empty($request->nim) && strlen($request->nim) >= 2) {
            $angkatan = '20' . substr($request->nim, 0, 2);
        }

        $updateData = [
            'name'     => $request->name,
            'nim'      => $request->nim,
            'angkatan' => $angkatan,
            'email'    => $request->email,
            'prodi'    => $request->prodi,
        ];

        if ($request->filled('role')) {
            $updateData['role'] = $request->role;
        }

        $user->update($updateData);

        // ==============================
        // KONVERSI MENJADI ALUMNI
        // ==============================
        if ($roleBefore !== 'alumni' && $request->role === 'alumni') {

            $mahasiswaData = MahasiswaData::where('user_id', $user->id)->first();

            $graduation_year = $mahasiswaData->angkatan
                ?? (!empty($user->nim) && strlen($user->nim) >= 2
                    ? '20' . substr($user->nim, 0, 2)
                    : null);

            $existingAlumni = AlumniData::where('user_id', $user->id)->first();

            if (!$existingAlumni) {
                AlumniData::create([
                    'user_id'              => $user->id,
                    'graduation_year'      => $graduation_year,
                    'phone_number'         => null,
                    'current_address'      => null,
                    'employment_status'    => null,
                    'company_name'         => null,
                    'position'             => null,
                    'work_address'         => null,
                    'industry_field'       => null,
                    'workplace_photo_path' => null,
                    'deskripsi'            => null,
                    'bidang_industri'      => null,
                ]);
            }

            if ($mahasiswaData) {
                $mahasiswaData->delete();
            }

            $user->update(['role' => 'alumni']);
        }

        return redirect()->route('student_data.index')->with('success', 'Data berhasil diperbarui!');
    }

    // ==============================
    // DETAIL DATA MAHASISWA
    // ==============================
    public function show($id)
    {
        $mahasiswa = User::findOrFail($id);

        if (auth()->user()->role !== 'admin' && auth()->id() !== $mahasiswa->id) {
            abort(403, 'Akses ditolak');
        }

        return view('student_data.show', compact('mahasiswa'));
    }

    // ==============================
    // HAPUS DATA MAHASISWA
    // ==============================
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        $user = User::findOrFail($id);

        // Hapus tabel mahasiswa
        MahasiswaData::where('user_id', $user->id)->delete();

        // Hapus tabel alumni (kalau ada)
        AlumniData::where('user_id', $user->id)->delete();

        // Hapus akun user
        $user->delete();

        return redirect()->route('student_data.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
