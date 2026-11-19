@extends('layouts.app')

@section('title', 'Daftar Calon')

@section('content')
    <h1>Daftar Calon Penerima</h1>
    <p class="lead">Seluruh calon beasiswa beserta status seleksinya.</p>

    <form class="search" method="GET" action="{{ route('mahasiswa.index') }}">
        <input type="text" name="cari" value="{{ $kataKunci }}" placeholder="Cari nama atau NIM">
        <button class="btn" type="submit">Cari</button>
        @if ($kataKunci !== '')
            <a class="btn btn-ghost" href="{{ route('mahasiswa.index') }}">Reset</a>
        @endif
    </form>

    <div class="tabs">
        <a href="{{ route('mahasiswa.index') }}" class="active">Semua</a>
        <a href="{{ route('mahasiswa.status', 'diterima') }}">Diterima</a>
        <a href="{{ route('mahasiswa.status', 'cadangan') }}">Cadangan</a>
        <a href="{{ route('mahasiswa.status', 'tidak-layak') }}">Tidak layak</a>
    </div>

    @if (count($daftar) > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th class="num">Smt</th>
                        <th class="num">IPK</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftar as $calon)
                        <tr>
                            <td class="muted">{{ $calon['nim'] }}</td>
                            <td><a href="{{ route('mahasiswa.show', $calon['id']) }}">{{ $calon['nama'] }}</a></td>
                            <td class="muted">{{ $calon['prodi'] }}</td>
                            <td class="num">{{ $calon['semester'] }}</td>
                            <td class="num">{{ $calon['ipk_format'] }}</td>
                            <td>@include('partials.badge', ['calon' => $calon])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="note">Tidak ada calon yang cocok dengan pencarian "{{ $kataKunci }}".</div>
    @endif
@endsection
