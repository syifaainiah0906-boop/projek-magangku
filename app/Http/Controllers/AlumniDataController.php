<?php

namespace App\Http\Controllers;

use App\Models\AlumniData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlumniDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnis = AlumniData::with('user')->latest()->paginate(10);
        return view('alumni_data.index', compact('alumnis'));
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
        
        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('workplace_photo')) {
            $data['workplace_photo_path'] = $request->file('workplace_photo')->store('alumni_photos', 'public');
        }

        AlumniData::create($data);

        return redirect()->route('alumni_data.index')->with('success', 'Data alumni berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AlumniData $alumniDatum)
    {
        return view('alumni_data.show', compact('alumniDatum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlumniData $alumniDatum)
    {
        // if ($alumniDatum->user_id !== Auth::id()) {
        //     abort(403);
        // }
        return view('alumni_data.edit', compact('alumniDatum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlumniData $alumniDatum)
    {
        if ($alumniDatum->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
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

        $data = $request->all();

        if ($request->hasFile('workplace_photo')) {
            if ($alumniDatum->workplace_photo_path) {
                Storage::disk('public')->delete($alumniDatum->workplace_photo_path);
            }
            $data['workplace_photo_path'] = $request->file('workplace_photo')->store('alumni_photos', 'public');
        }

        $alumniDatum->update($data);
        return redirect()->route('alumni_data.index')->with('success', 'Data alumni berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlumniData $alumniDatum)
    {
        if ($alumniDatum->user_id !== Auth::id()) {
            abort(403);
        }
        if ($alumniDatum->workplace_photo_path) {
            Storage::disk('public')->delete($alumniDatum->workplace_photo_path);
        }
        $alumniDatum->delete();
        return redirect()->route('alumni_data.index')->with('success', 'Data alumni berhasil dihapus!');
    }
}
