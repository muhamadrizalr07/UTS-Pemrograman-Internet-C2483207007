<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HitungSeleksi;

class HomeController extends Controller
{
    use HitungSeleksi;

    public function index()
    {
        $hasil = $this->olahSemua();

        return view('beranda', [
            'ringkasan' => $hasil['ringkasan'],
            'penerima'  => array_slice($hasil['peringkat'], 0, self::KUOTA),
        ]);
    }
}
