@extends('layouts.app')

@section('title', $calon['nama'])

@section('content')
    <div class="breadcrumb"><a href="{{ route('mahasiswa.index') }}">Daftar calon</a> / {{ $calon['nama'] }}</div>

    <h1>{{ $calon['nama'] }}</h1>
    <p class="lead">
        {{ $calon['nim'] }} · {{ $calon['prodi'] }}
        &nbsp;@include('partials.badge', ['calon' => $calon])
    </p>

    @if (! $calon['layak'])
        <div class="note no">
            Tidak memenuhi persyaratan:
            <ul>
                @foreach ($calon['alasan'] as $alasan)
                    <li>{{ $alasan }}</li>
                @endforeach
            </ul>
        </div>
    @elseif ($calon['catatan_seri'])
        <div class="note warn">{{ $calon['catatan_seri'] }}</div>
    @endif

    <div class="detail">
        <div>
            <h2>Data calon</h2>
            <dl class="facts">
                <div><dt>Semester</dt><dd>{{ $calon['semester'] }}</dd></div>
                <div><dt>IPK</dt><dd>{{ $calon['ipk_format'] }}</dd></div>
                <div><dt>Penghasilan orang tua</dt><dd>{{ $calon['penghasilan_format'] }}</dd></div>
                <div><dt>Tingkat prestasi</dt><dd>{{ $calon['tingkat_prestasi'] }}</dd></div>
                <div><dt>Prestasi</dt><dd>{{ $calon['prestasi'] }}</dd></div>
                @if ($calon['layak'])
                    <div><dt>Peringkat</dt><dd>{{ $calon['peringkat'] }} dari {{ $jumlahLayak }}</dd></div>
                @endif
            </dl>
        </div>

        <div>
            <h2>Rincian skor</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th class="num">Skor</th>
                            <th class="num">Bobot</th>
                            <th class="num">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IPK</td>
                            <td class="num">{{ $calon['skor']['ipk'] }}</td>
                            <td class="num">{{ $bobot['ipk'] }}%</td>
                            <td class="num">{{ $calon['kontribusi_format']['ipk'] }}</td>
                        </tr>
                        <tr>
                            <td>Penghasilan</td>
                            <td class="num">{{ $calon['skor']['penghasilan'] }}</td>
                            <td class="num">{{ $bobot['penghasilan'] }}%</td>
                            <td class="num">{{ $calon['kontribusi_format']['penghasilan'] }}</td>
                        </tr>
                        <tr>
                            <td>Prestasi</td>
                            <td class="num">{{ $calon['skor']['prestasi'] }}</td>
                            <td class="num">{{ $bobot['prestasi'] }}%</td>
                            <td class="num">{{ $calon['kontribusi_format']['prestasi'] }}</td>
                        </tr>
                        <tr>
                            <td>Semester</td>
                            <td class="num">{{ $calon['skor']['semester'] }}</td>
                            <td class="num">{{ $bobot['semester'] }}%</td>
                            <td class="num">{{ $calon['kontribusi_format']['semester'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Skor akhir</strong></td>
                            <td></td>
                            <td></td>
                            <td class="num"><strong>{{ $calon['skor_akhir_format'] }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @unless ($calon['layak'])
                <p class="muted small">Skor ditampilkan sebagai informasi; calon tidak diikutkan dalam pemeringkatan.</p>
            @endunless
        </div>
    </div>

    <div class="actions">
        <a class="btn btn-ghost" href="{{ route('mahasiswa.index') }}">Kembali ke daftar</a>
        <a class="btn btn-ghost" href="{{ route('peringkat') }}">Lihat peringkat</a>
    </div>
@endsection
