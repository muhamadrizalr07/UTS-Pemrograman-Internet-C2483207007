@extends('layouts.app')

@section('title', 'Kriteria')

@section('content')
    <h1>Kriteria &amp; Bobot</h1>
    <p class="lead">
        Setiap kriteria dikonversi menjadi skor 0–100, dikalikan bobot, lalu dijumlahkan
        menjadi skor akhir. Maksimal {{ $kuota }} calon yang menerima beasiswa.
    </p>

    <h2>Bobot penilaian</h2>
    <div class="stats">
        <div class="stat"><div class="value">{{ $bobot['ipk'] }}%</div><div class="label">IPK</div></div>
        <div class="stat"><div class="value">{{ $bobot['penghasilan'] }}%</div><div class="label">Penghasilan orang tua</div></div>
        <div class="stat"><div class="value">{{ $bobot['prestasi'] }}%</div><div class="label">Prestasi</div></div>
        <div class="stat"><div class="value">{{ $bobot['semester'] }}%</div><div class="label">Semester</div></div>
    </div>

    <h2>Syarat kelayakan</h2>
    <div class="note">
        <ul>
            @foreach ($syarat as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>

    <h2>Konversi IPK</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Rentang IPK</th><th class="num">Skor</th></tr></thead>
            <tbody>
                @foreach ($aturan_ipk as $aturan)
                    <tr><td>{{ $aturan['label'] }}</td><td class="num">{{ $aturan['skor'] }}</td></tr>
                @endforeach
                <tr class="row-dim"><td>&lt; 3,00</td><td class="num">0 (tidak layak)</td></tr>
            </tbody>
        </table>
    </div>

    <h2>Konversi penghasilan orang tua</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Penghasilan per bulan</th><th class="num">Skor</th></tr></thead>
            <tbody>
                @foreach ($aturan_penghasilan as $aturan)
                    <tr><td>{{ $aturan['label'] }}</td><td class="num">{{ $aturan['skor'] }}</td></tr>
                @endforeach
                <tr class="row-dim"><td>&gt; Rp 7.500.000</td><td class="num">0 (tidak layak)</td></tr>
            </tbody>
        </table>
    </div>

    <h2>Konversi prestasi</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Tingkat prestasi tertinggi</th><th class="num">Skor</th></tr></thead>
            <tbody>
                @foreach ($skor_prestasi as $tingkat => $skor)
                    <tr><td>{{ $tingkat }}</td><td class="num">{{ $skor }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2>Konversi semester</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Semester</th><th class="num">Skor</th></tr></thead>
            <tbody>
                @foreach ($skor_semester as $semester => $skor)
                    <tr><td>Semester {{ $semester }}</td><td class="num">{{ $skor }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2>Aturan skor sama</h2>
    <div class="note">
        Jika skor akhir sama, urutan ditentukan berturut-turut oleh: IPK lebih tinggi,
        skor prestasi lebih tinggi, penghasilan orang tua lebih rendah, lalu urutan abjad nama.
    </div>
@endsection
