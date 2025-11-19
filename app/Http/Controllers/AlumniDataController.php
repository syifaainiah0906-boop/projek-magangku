<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = auth()->user();

    // Daftar filter untuk dropdown (default kosong)
    $daftarProdi = collect([]);
    $daftarTahun = collect([]);

    // Query dasar ambil data alumni
    $query = AlumniData::with('user');

    // =====================================================================
    // ROLE ADMIN → bisa melihat semua alumni + filter prodi & tahun
    // =====================================================================
    if ($user->role === 'admin') {
        // Ambil daftar unik prodi dan tahun lulus untuk dropdown filter
        $daftarProdi = [
            'D3 Teknik Otomotif',
            'D3 Teknik Informatika',
            'D3 Budidaya Tanaman Perkebunan',
            'D4 Bisnis Digital',
            'D4 Akuntansi Bisnis Digital',
            'D4 Manajemen Pemasaran Internasional',
            'D4 Teknologi Rekayasa Multimedia',
        ];

        $daftarTahun = array_merge([], range(2020, now()->year));

        // Filter berdasarkan prodi
        if ($request->has('prodi') && $request->prodi !== 'Semua Prodi') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('prodi', $request->prodi);
            });
        }

        // Filter berdasarkan tahun lulus
        if ($request->has('tahun') && $request->tahun !== 'Semua Tahun') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('tahun_lulus', $request->tahun);
            });
        }
    }

    // =====================================================================
    // ROLE USER / ALUMNI → hanya bisa melihat datanya sendiri
    // =====================================================================
    else {
        $query->where('user_id', $user->id);
    }

    // =====================================================================
    // Filter pencarian (berlaku untuk semua role)
    // =====================================================================
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nim', 'like', "%{$search}%");
        });
    }

    // Ambil hasil query dengan pagination
    $alumnis = $query->latest()->paginate(10);

    // =====================================================================
    // Siapkan variabel untuk tombol Edit Data (data pribadi user)
    // =====================================================================
    if ($user->role === 'admin') {
        // Admin butuh koleksi data alumni untuk tabel → tidak ubah apa-apa
        $alumniDatum = $alumnis;
    } else {
        // User hanya punya satu data alumni
        $alumniDatum = AlumniData::where('user_id', $user->id)->first();
    }

    // Kirim semua data ke view
    return view('alumni_data.index', compact('alumnis', 'daftarProdi', 'daftarTahun', 'alumniDatum'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alumni_data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'graduation_year' => 'nullable|string|max:4',
        'phone_number' => 'nullable|string|max:20',
        'current_address' => 'nullable|string',
        'employment_status' => 'nullable|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'work_address' => 'nullable|string',
        'industry_field' => 'nullable|string|max:255',
        'workplace_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Ambil user lama (mahasiswa)
    $user = User::findOrFail($request->user_id);

    // Ubah role jadi alumni
    $user->update([
        'role' => 'alumni',
        'tahun_lulus' => $request->graduation_year,
    ]);

    // Simpan data tambahan ke tabel alumni_data
    $data = $request->except(['_token']);
    $data['user_id'] = $user->id;

    if ($request->hasFile('workplace_photo')) {
        $data['workplace_photo_path'] = $request->file('workplace_photo')->store('alumni_photos', 'public');
    }

    AlumniData::create($data);

    return redirect()->route('alumni_data.index')->with('success', 'Data alumni berhasil ditambahkan!');
}


    /**
     * Show the specified resource.
     */
    public function show(AlumniData $alumniDatum)
    {
        if (Auth::user()->role !== 'admin' && $alumniDatum->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin.');
        }

        return view('alumni_data.show', compact('alumniDatum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlumniData $alumniDatum)
{
    if (Auth::user()->role !== 'admin' && $alumniDatum->user_id !== Auth::id()) {
        abort(403, 'Anda tidak memiliki izin.');
    }

    return view('alumni_data.edit', compact('alumniDatum'));
}

public function update(Request $request, AlumniData $alumniDatum)
{
    if (Auth::user()->role !== 'admin' && $alumniDatum->user_id !== Auth::id()) {
        abort(403, 'Anda tidak memiliki izin.');
    }

    $request->validate([
        'graduation_year' => 'nullable|string|max:4',
        'phone_number' => 'nullable|string|max:20',
        'current_address' => 'nullable|string',
        'village' => 'nullable|string|max:100',
        'employment_status' => 'nullable|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'work_address' => 'nullable|string',
        'industry_field' => 'nullable|string|max:255',
        'workplace_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('workplace_photo')) {
        if ($alumniDatum->workplace_photo_path) {
            Storage::disk('public')->delete($alumniDatum->workplace_photo_path);
        }
        $data['workplace_photo_path'] = $request->file('workplace_photo')->store('alumni_photos', 'public');
    }

    $alumniDatum->update($data);

    return redirect()->route('alumni_data.show', $alumniDatum->id)
        ->with('success', 'Data alumni berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlumniData $alumniDatum)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin.');
        }

        if ($alumniDatum->workplace_photo_path) {
            Storage::disk('public')->delete($alumniDatum->workplace_photo_path);
        }

        $alumniDatum->delete();
        $alumniDatum->user()->delete();

        return redirect()->route('alumni_data.index')->with('success', 'Data Alumni berhasil dihapus!');
    }

    /**
     * Download PDF
     */
    public function downloadPdf(AlumniData $alumniDatum)
    {
        if (Auth::user()->role !== 'admin' && $alumniDatum->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $alumniDatum->load('user');
        $pdf = Pdf::loadView('alumni_data.pdf_template', compact('alumniDatum'));

        $fileName = 'Data_Alumni_' . str_replace(' ', '_', $alumniDatum->user->name) . '_' . $alumniDatum->id . '.pdf';
        return $pdf->download($fileName);
    }
}
