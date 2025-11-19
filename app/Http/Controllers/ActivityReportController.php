<?php

namespace App\Http\Controllers;

use App\Models\ActivityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ActivityReportController extends Controller
{
    /**
     * Menampilkan daftar laporan kegiatan.
     */
    public function index(Request $request)
{
    $reports = ActivityReport::with('user')->orderBy('activity_date', 'desc');

    // Filter pencarian (nama/NIM)
    if ($request->filled('search')) {
        $reports->whereHas('user', function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
        });
    }

    // Filter tanggal
    if ($request->filled('start_date')) {
        $reports->whereDate('activity_date', $request->start_date);
    }

    // Jika user biasa → hanya data dia sendiri
    if (Auth::user()->role !== 'admin') {
        $reports->where('user_id', Auth::id());
    }

    $allReports = $reports->get();

    return view('activity_reports.index', compact('allReports'));

    }

    /**
     * Mengambil jumlah laporan kegiatan per bulan via AJAX.
     */
    public function getMonthlyCount(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'count' => 'Error',
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $user = Auth::user();

        $query = ActivityReport::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        try {
            $count = $query->whereMonth('activity_date', $month)
                           ->whereYear('activity_date', $year)
                           ->count();

            return response()->json([
                'count' => $count,
                'bulan' => (int)$month,
                'tahun' => (int)$year,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getMonthlyCount: ' . $e->getMessage());
            return response()->json([
                'count' => 'Error',
                'message' => 'Server failed to process query'
            ], 500);
        }
    }

    /**
     * Form tambah laporan kegiatan.
     */
    public function create()
    {
        return view('activity_reports.create');
    }

    /**
     * Simpan laporan kegiatan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'semester' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'activity_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['photo_file_path'] = $request->file('photo')->store('photos', 'public');
        $validated['user_id'] = Auth::id();

        ActivityReport::create($validated);

        return redirect()->route('activity_reports.index')
            ->with('success', 'Laporan berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail laporan kegiatan.
     */
    public function show(ActivityReport $activityReport)
    {
        if (Auth::user()->role !== 'admin' && $activityReport->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('activity_reports.show', compact('activityReport'));
    }

    /**
     * Form edit laporan kegiatan.
     */
    public function edit(ActivityReport $activityReport)
{
    // Hanya admin yang boleh mengedit
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Anda tidak memiliki izin untuk mengedit laporan ini.');
    }

    return view('activity_reports.edit', compact('activityReport'));
}

/**
 * Update laporan kegiatan.
 */
public function update(Request $request, ActivityReport $activityReport)
{
    // Hanya admin yang boleh mengupdate
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Anda tidak memiliki izin untuk mengubah laporan ini.');
    }

    $validated = $request->validate([
        'activity_name' => 'required|string|max:255',
        'activity_date' => 'required|date',
        'description' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        if ($activityReport->photo_file_path) {
            Storage::disk('public')->delete($activityReport->photo_file_path);
        }

        $validated['photo_file_path'] = $request->file('photo')->store('photos', 'public');
    }

    $activityReport->update($validated);

    return redirect()->route('activity_reports.index')
        ->with('success', 'Laporan berhasil diperbarui!');
}
    /**
     * Hapus laporan kegiatan.
     */
    public function destroy(ActivityReport $activityReport)
    {
        if (Auth::user()->role !== 'admin' && $activityReport->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($activityReport->photo_file_path) {
            Storage::disk('public')->delete($activityReport->photo_file_path);
        }

        $activityReport->delete();

        return redirect()->route('activity_reports.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Download laporan kegiatan sebagai PDF.
     */
    public function downloadPdf(ActivityReport $activityReport)
{
    if (Auth::user()->role !== 'admin' && $activityReport->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $activityReport->load('user');

    // === Tambahan: Hitung urutan laporan ke-berapa ===
    $laporanKe = ActivityReport::where('user_id', $activityReport->user_id)
        ->where('id', '<=', $activityReport->id)
        ->orderBy('id')
        ->count();

    // Generate PDF dengan data tambahan
    $pdf = Pdf::loadView('activity_reports.pdf_template', compact('activityReport', 'laporanKe'));

    $userName = str_replace(' ', '_', $activityReport->user->name);
    $fileName = "Laporan_Kegiatan_{$userName}_{$activityReport->id}.pdf";

    return $pdf->download($fileName);
}
}
