<aside class="sidebar bg-white w-64 p-4">
    <h3>Menu</h3>
    <ul>
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="whitespace-nowrap">📊 Dashboard</a>
        </li>
        
        <li class="{{ request()->routeIs('activity_reports.index') ? 'active' : '' }}">
            <a href="{{ route('activity_reports.index') }}" class="whitespace-nowrap">📑 Laporan Kegiatan</a>
        </li>

        <li class="{{ request()->routeIs('semester_reports.index') ? 'active' : '' }}">
            <a href="{{ route('semester_reports.index') }}" class="whitespace-nowrap">📑 Laporan Semester</a>
        </li>

        @if (Auth::user()->role !== 'alumni')
            <li class="{{ request()->routeIs('student_data.index') ? 'active' : '' }}">
                <a href="{{ route('student_data.index') }}" class="whitespace-nowrap">🎓 Data Mahasiswa</a>
            </li>
        @endif

        @if (Auth::user()->role !== 'user')
            <li class="{{ request()->routeIs('alumni_data.index') ? 'active' : '' }}">
                <a href="{{ route('alumni_data.index') }}" class="whitespace-nowrap">👥 Data Alumni</a>
            </li>
        @endif
    </ul>
</aside>
