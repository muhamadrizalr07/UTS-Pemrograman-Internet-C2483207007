@extends('layouts.app')

@section('title', 'Status ' . $label)

@section('content')
    <div class="breadcrumb"><a href="{{ route('mahasiswa.index') }}">Daftar calon</a> / {{ $label }}</div>

    <h1>Calon {{ $label }}</h1>
    <p class="lead">{{ count($daftar) }} calon dengan status {{ $label }}.</p>

    <div class="tabs">
        <a href="{{ route('mahasiswa.index') }}">Semua</a>
        <a href="{{ route('mahasiswa.status', 'diterima') }}" class="{{ $label === 'Diterima' ? 'active' : '' }}">Diterima</a>
        <a href="{{ route('mahasiswa.status', 'cadangan') }}" class="{{ $label === 'Cadangan' ? 'active' : '' }}">Cadangan</a>
        <a href="{{ route('mahasiswa.status', 'tidak-layak') }}" class="{{ $label === 'Tidak Layak' ? 'active' : '' }}">Tidak layak</a>
    </div>

    @if (count($daftar) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th class="num">IPK</th>
                        <th class="num">Skor akhir</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftar as $calon)
                        <tr>
                            <td>{{ $calon['peringkat'] ?? '–' }}</td>
                            <td><a href="{{ route('mahasiswa.show', $calon['id']) }}">{{ $calon['nama'] }}</a></td>
                            <td class="num">{{ $calon['ipk_format'] }}</td>
                            <td class="num">{{ $calon['layak'] ? $calon['skor_akhir_format'] : '–' }}</td>
                            <td class="muted small">
                                @if ($calon['layak'])
                                    {{ $calon['catatan_seri'] ?? 'Memenuhi seluruh syarat.' }}
                                @else
                                    {{ implode('; ', $calon['alasan']) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="note">Belum ada calon dengan status ini.</div>
    @endif
@endsection
