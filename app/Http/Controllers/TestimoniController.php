<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
    /**
     * Pastikan hanya user yang sudah login bisa mengirim testimoni.
     */
    public function index(Request $request)
    {
        $this->middleware('auth');
    }

    /**
     * Simpan testimoni ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'isi_testimoni' => 'required|string|max:500',
        ]);

        // Simpan data ke tabel 'testimonis'
        Testimoni::create([
            'user_id' => auth()->id(),
            'isi_testimoni' => $request->isi_testimoni,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Terima kasih! Testimoni Anda telah dikirim.');
    }
    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);

        // Hanya user pemilik testimoni atau admin yang boleh hapus
        if (auth()->id() !== $testimoni->user_id && auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus testimoni ini.');
        }

        $testimoni->delete();

        return redirect()->back()->with('success', 'Testimoni berhasil dihapus.');
    }

}
