<?php

// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    // Menampilkan halaman formulir laporan semester
    public function index()
    {
        return view('lapsemestermhs');
    }

    // Menyimpan data formulir ke database
    public function store(Request $request)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:255',
            'semester' => 'required|numeric|min:1|max:14',
            'ip' => 'required|numeric|min:0|max:4',
            'ipk' => 'required|numeric|min:0|max:4',
            'khs_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // 2. Mengunggah file KHS
        $file = $request->file('khs_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        // 3. Menyimpan data ke database
        Report::create([
            'user_id' => Auth::id(),
            'name' => $validatedData['name'],
            'nim' => $validatedData['nim'],
            'prodi' => $validatedData['prodi'],
            'semester' => $validatedData['semester'],
            'ip' => $validatedData['ip'],
            'ipk' => $validatedData['ipk'],
            'khs_file' => $fileName,
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Laporan semester berhasil dikirim.');
    }
}