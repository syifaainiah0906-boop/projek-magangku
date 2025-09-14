<?php

namespace App\Http\Controllers;

use App\Models\SemesterReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SemesterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = SemesterReport::with('user')->latest()->paginate(10);
        return view('semester_reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('semester_reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|max:255',
            'ip' => 'required|numeric|min:0|max:4',
            'ipk' => 'required|numeric|min:0|max:4',
            'khs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB limit
        ]);

        $path = $request->file('khs')->store('khs', 'public');

        SemesterReport::create([
            'user_id' => Auth::id(),
            'semester' => $request->semester,
            'ip' => $request->ip,
            'ipk' => $request->ipk,
            'khs_file_path' => $path,
        ]);

        return redirect()->route('semester_reports.index')->with('success', 'Laporan semester berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SemesterReport $semesterReport)
    {
        // Otorisasi: Pastikan hanya pemilik laporan atau admin yang bisa melihatnya.
        // if ($semesterReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
        //     abort(403); // Forbidden
        // }
        return view('semester_reports.show', compact('semesterReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SemesterReport $semesterReport)
    {
        // Cek otorisasi untuk memastikan pengguna yang login berhak mengedit data ini
        // if ($semesterReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
        //     abort(403);
        // }
        
        // ✅ Tampilkan form edit di sini
        return view('semester_reports.edit', compact('semesterReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SemesterReport $semesterReport)
    {
        // Cek otorisasi untuk memastikan pengguna yang login berhak mengedit data ini
        // if ($semesterReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
        //     abort(403);
        // }

        // ✅ Hapus return view di sini supaya proses lanjut
        $request->validate([
            'semester' => 'required|string|max:255',
            'ip' => 'required|numeric|min:0|max:4',
            'ipk' => 'required|numeric|min:0|max:4',
            'khs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        
        $data = $request->all(); // Ambil semua data dari request
    
        if ($request->hasFile('khs')) {
            // Hapus file lama jika ada
            if ($semesterReport->khs_file_path) {
                Storage::disk('public')->delete($semesterReport->khs_file_path);
            }
            $data['khs_file_path'] = $request->file('khs')->store('khs', 'public');
        }
    
        // Lakukan update pada model
        $semesterReport->update([
            'semester' => $data['semester'],
            'ip' => $data['ip'],
            'ipk' => $data['ipk'],
            'khs_file_path' => $data['khs_file_path'] ?? $semesterReport->khs_file_path,
        ]);
    
        return redirect()->route('semester_reports.index')->with('success', 'Laporan semester berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SemesterReport $semesterReport)
    {
        // Perbaiki otorisasi: Izinkan pemilik laporan ATAU admin untuk menghapus.
        // if ($semesterReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
        //     abort(403);
        // }

        if ($semesterReport->khs_file_path) {
            Storage::disk('public')->delete($semesterReport->khs_file_path);
        } 

        $semesterReport->delete();

        return redirect()->route('semester_reports.index')->with('success', 'Laporan semester berhasil dihapus!');
    }
}
