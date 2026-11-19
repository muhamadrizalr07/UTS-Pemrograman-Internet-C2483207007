@extends('layouts.app')

@section('title', 'Peringkat')

@section('content')
    <h1>Peringkat Calon Penerima</h1>
    <p class="lead">
        {{ $ringkasan['layak'] }} calon memenuhi syarat. {{ $ringkasan['kuota'] }} peringkat teratas
        menerima beasiswa, sisanya menjadi cadangan.
    </p>

    @if ($ringkasan['seri_di_batas_kuota'])
        <div class="note warn">Skor sama terjadi tepat di batas kuota. Urutan ditentukan oleh aturan tie-break.</div>
    @endif

    @if (count($peringkat) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th class="num">IPK</th>
                        <th class="num">Skor akhir</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peringkat as $calon)
                        <tr>
                            <td>{{ $calon['peringkat'] }}</td>
                            <td><a href="{{ route('mahasiswa.show', $calon['id']) }}">{{ $calon['nama'] }}</a></td>
                            <td class="num">{{ $calon['ipk_format'] }}</td>
                            <td class="num">{{ $calon['skor_akhir_format'] }}</td>
                            <td>@include('partials.badge', ['calon' => $calon])</td>
                            <td class="muted small">{{ $calon['catatan_seri'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="note">Tidak ada calon yang memenuhi syarat, sehingga belum ada peringkat.</div>
    @endif

    <h2>Tidak layak ({{ count($tidakLayak) }})</h2>
    @if (count($tidakLayak) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Nama</th><th>Alasan</th></tr>
                </thead>
                <tbody>
                    @foreach ($tidakLayak as $calon)
                        <tr>
                            <td><a href="{{ route('mahasiswa.show', $calon['id']) }}">{{ $calon['nama'] }}</a></td>
                            <td class="muted">
                                @foreach ($calon['alasan'] as $alasan)
                                    {{ $alasan }}@if (! $loop->last); @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="note">Semua calon memenuhi syarat.</div>
    @endif
@endsection
