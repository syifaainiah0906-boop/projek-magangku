<?php

namespace App\Http\Controllers;

use App\Models\SemesterReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SemesterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil nilai filter dari request
        $search = $request->input('search');
        $semesterFilter = $request->input('semester'); // <-- BARU: Ambil nilai semester

        // Memulai query builder dengan eager loading untuk data user
        $query = SemesterReport::with('user');
        
        // --- LOGIKA FILTER DAN OTORISASI UNTUK ADMIN ---
        if (auth()->user()->role === 'admin') {
            
            // 1. Filter berdasarkan SEMESTER (hanya Admin)
           if ($semesterFilter) {
               $query->where('semester', $semesterFilter);
          }
            
            // 2. Filter berdasarkan NAMA (untuk Admin)
            if ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }
            
        } else {
            // --- LOGIKA UNTUK PENGGUNA BIASA (USER) ---
            // Hanya tampilkan laporan yang dimiliki oleh user_id yang sedang login
            $query->where('user_id', auth()->user()->id);
        }

        // Ambil SEMUA data yang sesuai kriteria filter/otorisasi (tanpa paginasi di level query)
        // Urutkan berdasarkan user_id (agar laporan mahasiswa yang sama berdekatan) dan semester
       $allReports = $query->orderBy('semester', 'desc')->get();

        // 2. KELOMPOKKAN data berdasarkan user_id (NIM/Mahasiswa)
        // Laravel Collection groupBy() akan mengelompokkan semua laporan per mahasiswa.
       $groupedReports = $allReports
        ->filter(function ($report) use ($semesterFilter) {
            return !$semesterFilter || $report->semester == $semesterFilter;
        })
        ->groupBy('user_id');

        // Mengganti 'reports' dengan 'groupedReports'
        return view('semester_reports.index', compact('groupedReports')); 
        // Kita hapus $reports->links() di view karena paginasi sudah tidak digunakan
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
        // Anda mungkin ingin mengaktifkan kebijakan otorisasi (Gate/Policy) di sini
        // if ($semesterReport->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
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
        // if ($semesterReport->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        //     abort(403);
        // }
        
        return view('semester_reports.edit', compact('semesterReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SemesterReport $semesterReport)
    {
        // Cek otorisasi untuk memastikan pengguna yang login berhak mengedit data ini
        // if ($semesterReport->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        //     abort(403);
        // }

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
        // if ($semesterReport->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        //     abort(403);
        // }

        if ($semesterReport->khs_file_path) {
            Storage::disk('public')->delete($semesterReport->khs_file_path);
        } 

        $semesterReport->delete();

        return redirect()->route('semester_reports.index')->with('success', 'Laporan semester berhasil dihapus!');
    }
    // ====================================================================
    // METODE BARU: DOWNLOAD PDF
    // ====================================================================

    /**
     * Membuat dan mengunduh laporan kegiatan yang spesifik sebagai PDF.
     */
    public function downloadPdf(SemesterReport $semesterReport)
    {
        // Otorisasi: Hanya Admin atau pemilik yang bisa mendownload
        if (Auth::user()->role !== 'admin' && $semesterReport->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Memuat relasi 'user' jika belum dimuat
        $semesterReport->load('user');

        // Memuat view khusus PDF
        $pdf = Pdf::loadView('semester_reports.pdf_template', compact('semesterReport'));
        
        // Mengatur nama file
        $userName = str_replace(' ', '_', $semesterReport->user->name);
        $fileName = 'Laporan_Semester_' . $userName . '_' . $semesterReport->id . '.pdf';

        // Mengembalikan respons download
        return $pdf->download($fileName);
    }
}
