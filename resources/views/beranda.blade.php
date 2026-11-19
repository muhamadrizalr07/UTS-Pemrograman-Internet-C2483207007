@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h1>Seleksi Beasiswa</h1>
    <p class="lead">
        Perhitungan skor, pengecekan kelayakan, dan pemeringkatan calon penerima beasiswa
        berdasarkan IPK, penghasilan orang tua, prestasi, dan semester.
    </p>

    <div class="stats">
        <a class="stat" href="{{ route('mahasiswa.index') }}">
            <div class="value">{{ $ringkasan['total'] }}</div>
            <div class="label">Total calon</div>
        </a>
        <a class="stat" href="{{ route('mahasiswa.status', 'diterima') }}">
            <div class="value">{{ $ringkasan['diterima'] }}</div>
            <div class="label">Diterima (kuota {{ $ringkasan['kuota'] }})</div>
        </a>
        <a class="stat" href="{{ route('mahasiswa.status', 'cadangan') }}">
            <div class="value">{{ $ringkasan['cadangan'] }}</div>
            <div class="label">Cadangan</div>
        </a>
        <a class="stat" href="{{ route('mahasiswa.status', 'tidak-layak') }}">
            <div class="value">{{ $ringkasan['tidak_layak'] }}</div>
            <div class="label">Tidak layak</div>
        </a>
    </div>

    <h2>Penerima beasiswa</h2>
    @if (count($penerima) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th class="num">Skor akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penerima as $calon)
                        <tr>
                            <td>{{ $calon['peringkat'] }}</td>
                            <td><a href="{{ route('mahasiswa.show', $calon['id']) }}">{{ $calon['nama'] }}</a></td>
                            <td class="muted">{{ $calon['prodi'] }}</td>
                            <td class="num">{{ $calon['skor_akhir_format'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="note">Belum ada calon yang memenuhi syarat.</div>
    @endif

    @if ($ringkasan['seri_di_batas_kuota'])
        <div class="note warn">Ada skor sama pada batas kuota. Urutan ditentukan oleh aturan tie-break (lihat halaman Peringkat).</div>
    @endif

    <div class="actions">
        <a class="btn" href="{{ route('peringkat') }}">Lihat peringkat lengkap</a>
        <a class="btn btn-ghost" href="{{ route('kriteria') }}">Kriteria &amp; bobot</a>
    </div>
@endsection
