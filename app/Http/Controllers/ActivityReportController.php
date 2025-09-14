<?php

namespace App\Http\Controllers;

use App\Models\ActivityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActivityReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        // Memulai query builder dengan eager loading untuk data user
        $query = ActivityReport::with('user');

        // Jika ada nilai search, tambahkan kondisi pencarian
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Ambil data laporan terbaru dengan paginasi
        $reports = $query->latest()->paginate(10);
        return view('activity_reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activity_reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'activity_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        ActivityReport::create([
            'user_id' => Auth::id(),
            'semester' => $request->semester,
            'activity_date' => $request->activity_date,
            'activity_name' => $request->activity_name,
            'position' => $request->position,
            'description' => $request->description,
            'photo_file_path' => $path,
        ]);

        return redirect()->route('activity_reports.index')->with('success', 'Laporan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityReport $activityReport)
    {
        // Pastikan pengguna hanya bisa melihat laporannya sendiri
        // if ($activityReport->user_id !== Auth::id()) {
        //     abort(403);
        // }
        return view('activity_reports.show', compact('activityReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityReport $activityReport)
    {
        // Periksa jika pengguna adalah admin ATAU pemilik laporan
        // if ($activityReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
        //     abort(403);
        // }
        return view('activity_reports.edit', compact('activityReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityReport $activityReport)
    {

    // Periksa jika pengguna adalah admin ATAU pemilik laporan
    // if ($activityReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
    //     abort(403, 'Anda tidak memiliki hak untuk melakukan ini.');
    // }

        // Aturan validasi yang diperbarui
        $validatedData = $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada foto baru diunggah
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($activityReport->photo_file_path) {
                Storage::disk('public')->delete($activityReport->photo_file_path);
            }
            // Simpan foto baru dan update path
            $validatedData['photo_file_path'] = $request->file('photo')->store('photos', 'public');
        }

        // Perbarui data laporan
        $activityReport->update($validatedData);

        return redirect()->route('activity_reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityReport $activityReport)
    {
        // Periksa jika pengguna adalah admin ATAU pemilik laporan
        if ($activityReport->user_id !== Auth::id() && !Auth::user()->user_admin) {
            abort(403);
        }

        // Hapus file foto terkait
        if ($activityReport->photo_file_path) {
            Storage::disk('public')->delete($activityReport->photo_file_path);
        }

        $activityReport->delete();

        return redirect()->route('activity_reports.index')->with('success', 'Laporan berhasil dihapus!');
    }
}