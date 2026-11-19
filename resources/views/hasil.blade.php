@extends('layouts.app')

@section('title', 'Hasil Skor')

@section('content')
    <h1>Hasil Perhitungan Skor</h1>
    <p class="lead">
        Skor tiap kriteria (0–100) dan skor akhir berbobot
        (IPK {{ $bobot['ipk'] }}%, penghasilan {{ $bobot['penghasilan'] }}%,
        prestasi {{ $bobot['prestasi'] }}%, semester {{ $bobot['semester'] }}%).
    </p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="num">IPK</th>
                    <th class="num">Peng.</th>
                    <th class="num">Prestasi</th>
                    <th class="num">Smt</th>
                    <th class="num">Skor akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftar as $calon)
                    <tr class="{{ $calon['layak'] ? '' : 'row-dim' }}">
                        <td><a href="{{ route('mahasiswa.show', $calon['id']) }}">{{ $calon['nama'] }}</a></td>
                        <td class="num">{{ $calon['skor']['ipk'] }}</td>
                        <td class="num">{{ $calon['skor']['penghasilan'] }}</td>
                        <td class="num">{{ $calon['skor']['prestasi'] }}</td>
                        <td class="num">{{ $calon['skor']['semester'] }}</td>
                        <td class="num">{{ $calon['skor_akhir_format'] }}</td>
                        <td>@include('partials.badge', ['calon' => $calon])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="muted small">
        Baris redup adalah calon yang tidak memenuhi syarat; skornya hanya sebagai informasi
        dan tidak diikutkan dalam pemeringkatan.
    </p>

    <div class="actions">
        <a class="btn" href="{{ route('peringkat') }}">Lihat peringkat</a>
    </div>
@endsection
