<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AlumniData;
use App\Models\User;
use App\Models\ActivityReport;
use App\Models\SemesterReport;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard sesuai dengan peran pengguna.
     *
     * @param 	\Illuminate\Http\Request 	$request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $user = Auth::user();
        
        if (!$user) {
            // Pengalihan ke login jika pengguna belum terautentikasi
            return redirect('/login'); 
        }

        // --- Logika Filter Bulan/Tahun dari Request ---
        // Jika ada di request, gunakan nilai tersebut. Jika tidak, gunakan bulan/tahun saat ini.
        $month = $request->query('month') ? (int)$request->query('month') : Carbon::now()->month;
        $year = $request->query('year') ? (int)$request->query('year') : Carbon::now()->year;
        
        // Pastikan $month berada dalam rentang 1-12
        $month = max(1, min(12, $month)); 

        // Nama bulan untuk tampilan card yang difilter
        $currentMonthName = Carbon::create($year, $month)->locale('id')->isoFormat('MMMM YYYY');
        $currentYear = Carbon::now()->year; // Tahun saat ini untuk diagram tren tahunan

        if ($user->role === 'user') {
            // --- Logika untuk Role Mahasiswa (USER) ---
            
            $activityReportsCount = ActivityReport::where('user_id', $user->id)->count();

            // Mengecek apakah jumlah laporan kegiatan kurang dari 20
            $isKegiatanKurang = $activityReportsCount < 20;

            // Ambil data IP dan label semester untuk grafik
            $semesterReportsData = SemesterReport::where('user_id', $user->id)
                ->orderBy('id', 'asc')
                ->get();
                
            $nilaiIp = $semesterReportsData->pluck('ip')->toArray();
            $labelsSemester = $semesterReportsData->pluck('semester')->toArray();

            // Pastikan view ini ada
            return view('dashboardmhs', compact('user', 'activityReportsCount', 'nilaiIp', 'labelsSemester', 'isKegiatanKurang'));
        }

        if ($user->role === 'admin') {
            // --- Logika untuk Role Admin ---
            
            // 1. Statistik Umum
            $totalAlumni = AlumniData::count();
            $activeStudents = User::where('role', 'user')->count();

            // KONEKSI ACTIVITY REPORT: Menghitung kegiatan berdasarkan BULAN dan TAHUN yang DIPILIH (untuk card filter)
            $monthlyActivitiesCount = ActivityReport::whereMonth('activity_date', $month)
                                             ->whereYear('activity_date', $year)
                                             ->count();
            
            $semesterReports = SemesterReport::count();
            
            $prodiCounts = User::select('prodi')
                               ->selectRaw('count(*) as count')
                               ->where('role', 'user')
                               ->whereNotNull('prodi')
                               ->groupBy('prodi')
                               ->get();

            // --- Logika Data Chart Tren Kegiatan Bulanan (SELALU TAHUN INI) ---
            $monthlyActivities = ActivityReport::select(
                    DB::raw('MONTH(activity_date) as month'),
                    DB::raw('COUNT(*) as total')
                )
                // Filter hanya data tahun saat ini untuk tren tahunan
                ->whereYear('activity_date', $currentYear) 
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            $activityCounts = array_fill(1, 12, 0); 
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            foreach ($monthlyActivities as $activity) {
                $activityCounts[$activity->month] = $activity->total;
            }

            $chartData = array_values($activityCounts); 
            // --- AKHIR: Logika Data Chart Tren Kegiatan Bulanan ---

            // 2. Logika Filter Angkatan
            $selectedAngkatan = $request->query('angkatan');

            // Ambil semua tahun angkatan unik dari NIM
            $angkatanOptions = User::select(DB::raw('SUBSTRING(nim, 1, 4) as tahun'))
                ->where('role', 'user')
                ->whereNotNull('nim')
                ->distinct()
                ->pluck('tahun')
                ->map(fn ($tahun) => (int)$tahun)
                ->sortDesc()
                ->values()
                ->all();

            // Mulai query untuk data mahasiswa yang akan ditampilkan di tabel
            $query = User::where('role', 'user')
                         ->whereNotNull('nim'); 

            // Terapkan filter jika 'angkatan' dipilih
            if ($selectedAngkatan) {
                $query->where(DB::raw('SUBSTRING(nim, 1, 4)'), $selectedAngkatan);
            }

            // Ambil data mahasiswa yang sudah difilter
            $mahasiswas = $query->get();
            
            // 3. Mengirim data ke view
            return view('dashboardmhs', compact(
                'user', 
                'totalAlumni', 
                'activeStudents', 
                'monthlyActivitiesCount',
                'currentMonthName', 
                'semesterReports', 
                'prodiCounts',
                'mahasiswas', 
                'selectedAngkatan',
                'angkatanOptions',
                'chartData',
                'chartLabels',
                'month', 
                'year'
            ));
        }
        
        // Default return jika role tidak dikenali
        return redirect('/');
    }
}
