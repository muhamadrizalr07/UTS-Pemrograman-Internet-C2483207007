<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HitungSeleksi;

class SeleksiController extends Controller
{
    use HitungSeleksi;

    /** Hasil perhitungan skor seluruh calon (urut sesuai data awal). */
    public function hasil()
    {
        $hasil = $this->olahSemua();

        return view('hasil', [
            'daftar'    => $hasil['semua'],
            'bobot'     => self::BOBOT,
            'ringkasan' => $hasil['ringkasan'],
        ]);
    }

    /** Pemeringkatan calon yang layak dan daftar calon tidak layak. */
    public function peringkat()
    {
        $hasil = $this->olahSemua();

        return view('peringkat', [
            'peringkat'  => $hasil['peringkat'],
            'tidakLayak' => $hasil['tidak_layak'],
            'ringkasan'  => $hasil['ringkasan'],
        ]);
    }
}
