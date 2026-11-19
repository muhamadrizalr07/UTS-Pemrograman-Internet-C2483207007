<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HitungSeleksi;

class KriteriaController extends Controller
{
    use HitungSeleksi;

    public function index()
    {
        return view('kriteria', $this->dataKriteria());
    }
}
