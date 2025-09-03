<aside class="sidebar">
    <h3>Menu</h3>
    <ul>
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">📊 Dashboard</a>
        </li>
        
        <li class="{{ request()->routeIs('activity_reports.index') ? 'active' : '' }}">
            <a href="{{ route('activity_reports.index') }}">📑 Laporan Kegiatan</a>
        </li>

        <li class="{{ request()->routeIs('semester_reports.index') ? 'active' : '' }}">
            <a href="{{ route('semester_reports.index') }}">📑 Laporan Semester</a>
        </li>
        @if (Auth::user()->role !== 'user')
            <li class="{{ request()->routeIs('alumni_data.index') ? 'active' : '' }}">
                <a href="{{ route('alumni_data.index') }}">👥 Data Alumni</a>
            </li>
        @endif
    </ul>
</aside>