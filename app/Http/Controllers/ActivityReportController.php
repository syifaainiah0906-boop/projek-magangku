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
        $query = ActivityReport::with('user');

        // if ($request->filled('search')) {
        //     $search = $request->input('search');
        //     $query->whereHas('user', function ($q) use ($search) {
        //         $q->where('name', 'like', "%{$search}%")
        //           ->orWhere('nim', 'like', "%{$search}%");
        //     })->orWhere('activity_name', 'like', "%{$search}%");
        // }

        $reports = $query->latest()->paginate(10); // Menggunakan paginate untuk halaman
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
        //     abort(403); // Forbidden
        // }
        return view('activity_reports.show', compact('activityReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityReport $activityReport)
    {
        // Pastikan pengguna hanya bisa mengedit laporannya sendiri
        if ($activityReport->user_id !== Auth::id()) {
            abort(403);
        }
        return view('activity_reports.edit', compact('activityReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityReport $activityReport)
    {
        // Pastikan pengguna hanya bisa mengupdate laporannya sendiri
        if ($activityReport->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'semester' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'activity_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($activityReport->photo_file_path) {
                Storage::disk('public')->delete($activityReport->photo_file_path);
            }
            $data['photo_file_path'] = $request->file('photo')->store('photos', 'public');
        }

        $activityReport->update($data);

        return redirect()->route('activity_reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityReport $activityReport)
    {
        // Pastikan pengguna hanya bisa menghapus laporannya sendiri
        if ($activityReport->user_id !== Auth::id()) {
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
