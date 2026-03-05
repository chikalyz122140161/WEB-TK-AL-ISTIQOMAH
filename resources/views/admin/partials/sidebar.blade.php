<a href="{{ route('admin.dashboard') }}" class="sidebar__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z"/><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15.75a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"/></svg>
    Dashboard
</a>

<div class="sidebar__divider"></div>
<span class="sidebar__label">Manajemen Data</span>

<a href="{{ route('admin.pengguna.index') }}" class="sidebar__item {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
    Kelola Pengguna
</a>
<a href="{{ route('admin.siswa.index') }}" class="sidebar__item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/><path d="M6 16.5a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Zm9.75 0a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Zm-3.75 3a3.75 3.75 0 0 1-3.75-3.75V14.2a1.5 1.5 0 0 1 .885-1.362l.5-.24a1.5 1.5 0 0 1 1.23 0l.5.24A1.5 1.5 0 0 1 12 14.2v1.55a3.75 3.75 0 0 1-3.75 3.75Zm0-2.25a1.5 1.5 0 0 0 1.5-1.5V14.2l-.5-.24a.25.25 0 0 0-.2 0l-.5.24v1.55a1.5 1.5 0 0 0 1.5 1.5Z"/><path fill-rule="evenodd" d="M3.019 11.114a.75.75 0 0 1 .853.604 49.77 49.77 0 0 0 3.846 13.4.75.75 0 1 1-1.346.666A51.27 51.27 0 0 1 2.415 11.967a.75.75 0 0 1 .604-.853Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M20.981 11.114a.75.75 0 0 1 .604.853 51.27 51.27 0 0 1-3.957 13.817.75.75 0 0 1-1.346-.666 49.77 49.77 0 0 0 3.846-13.4.75.75 0 0 1 .853-.604Z" clip-rule="evenodd"/></svg>
    Kelola Siswa
</a>

<div class="sidebar__divider"></div>
<span class="sidebar__label">Sistem</span>

<a href="{{ route('admin.backup.index') }}" class="sidebar__item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm.53 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v5.69a.75.75 0 0 0 1.5 0v-5.69l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd"/></svg>
    Backup Database
</a>
