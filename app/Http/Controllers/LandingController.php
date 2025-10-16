<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniData;

class LandingController extends Controller
{
    public function index()
    {
        // Hitung jumlah mahasiswa penerima beasiswa (role = 'mahasiswa')
        $jumlahMahasiswaBeasiswa = User::where('role', 'mahasiswa')->count();

        // Hitung jumlah alumni terdaftar
        $jumlahAlumni = AlumniData::count();

        // Karena tidak ada data program beasiswa aktif, kita buat nilainya statis = 1
        $programBeasiswaAktif = 1;

        return view('landing', compact(
            'jumlahMahasiswaBeasiswa',
            'jumlahAlumni',
            'programBeasiswaAktif'
        ));
    }
}
