<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HitungSeleksi;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    use HitungSeleksi;

    /** Daftar seluruh calon penerima, dengan pencarian nama/NIM lewat ?cari=. */
    public function index(Request $request)
    {
        $daftar = $this->olahSemua()['semua'];
        $kataKunci = trim((string) $request->query('cari', ''));

        if ($kataKunci !== '') {
            $daftar = array_values(array_filter($daftar, fn ($c) =>
                stripos($c['nama'], $kataKunci) !== false || stripos($c['nim'], $kataKunci) !== false
            ));
        }

        return view('mahasiswa.index', [
            'daftar'    => $daftar,
            'kataKunci' => $kataKunci,
        ]);
    }

    /** Detail satu calon penerima berdasarkan parameter URL {id}. */
    public function show(int $id)
    {
        $hasil = $this->olahSemua();
        $calon = collect($hasil['semua'])->firstWhere('id', $id);

        abort_if($calon === null, 404, 'Calon penerima tidak ditemukan.');

        return view('mahasiswa.show', [
            'calon'   => $calon,
            'bobot'   => self::BOBOT,
            'jumlahLayak' => $hasil['ringkasan']['layak'],
        ]);
    }

    /** Penyaringan berdasarkan status lewat parameter URL {status}. */
    public function byStatus(string $status)
    {
        $label = array_search($status, self::STATUS_SLUG, true);

        abort_if($label === false, 404);

        $daftar = array_values(array_filter(
            $this->olahSemua()['semua'],
            fn ($c) => $c['status_slug'] === $status
        ));

        // Urutkan berdasarkan peringkat; yang tidak punya peringkat ditaruh di akhir.
        usort($daftar, fn ($a, $b) => ($a['peringkat'] ?? PHP_INT_MAX) <=> ($b['peringkat'] ?? PHP_INT_MAX));

        return view('mahasiswa.status', [
            'label'  => $label,
            'daftar' => $daftar,
        ]);
    }
}
