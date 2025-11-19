<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniData;
use App\Models\Testimoni;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil testimoni terbaru dan join dengan data user
        $testimonis = Testimoni::with('user')->latest()->take(6)->get();

        // Hitung jumlah mahasiswa aktif (role = user)
        $activeStudents = User::where('role', 'user')->count();

        // Hitung jumlah alumni
        $jumlahAlumni = AlumniData::count();

        // Sementara, 1 program beasiswa aktif
        $programBeasiswaAktif = 1;

        // Kirim data ke landing
        return view('landing', compact(
            'testimonis',
            'activeStudents',
            'jumlahAlumni',
            'programBeasiswaAktif'
        ));
    }
}
