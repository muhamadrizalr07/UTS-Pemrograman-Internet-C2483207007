<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') · Seleksi Beasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="container bar">
            <a class="brand" href="{{ route('beranda') }}">Seleksi Beasiswa</a>
            <nav class="nav">
                <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('mahasiswa.index') }}" class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">Calon</a>
                <a href="{{ route('kriteria') }}" class="{{ request()->routeIs('kriteria') ? 'active' : '' }}">Kriteria</a>
                <a href="{{ route('hasil') }}" class="{{ request()->routeIs('hasil') ? 'active' : '' }}">Hasil Skor</a>
                <a href="{{ route('peringkat') }}" class="{{ request()->routeIs('peringkat') ? 'active' : '' }}">Peringkat</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

</body>
</html>
