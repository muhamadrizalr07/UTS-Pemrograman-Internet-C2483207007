<?php

namespace App\Http\Controllers\Concerns;

use App\Models\CalonPenerima;

/**
 * Seluruh logika perhitungan skor, kelayakan, dan pemeringkatan beasiswa.
 * Trait ini dipakai oleh Controller sehingga semua perhitungan berada
 * di kode PHP Controller, bukan di Blade View.
 */
trait HitungSeleksi
{
    /** Bobot kriteria (persen). Total harus 100. */
    protected const BOBOT = ['ipk' => 35, 'penghasilan' => 30, 'prestasi' => 25, 'semester' => 10];

    /** Jumlah maksimal penerima beasiswa. */
    protected const KUOTA = 5;

    /** Syarat kelayakan. */
    protected const IPK_MINIMUM = 3.00;
    protected const PENGHASILAN_MAKSIMUM = 7500000;
    protected const SEMESTER_MINIMUM = 3;
    protected const SEMESTER_MAKSIMUM = 8;

    /** Aturan konversi ke skor 0-100 (dicek dari atas ke bawah). */
    protected const ATURAN_IPK = [
        ['min' => 3.90, 'skor' => 100, 'label' => '≥ 3,90'],
        ['min' => 3.75, 'skor' => 90,  'label' => '3,75 – 3,89'],
        ['min' => 3.50, 'skor' => 80,  'label' => '3,50 – 3,74'],
        ['min' => 3.25, 'skor' => 70,  'label' => '3,25 – 3,49'],
        ['min' => 3.00, 'skor' => 60,  'label' => '3,00 – 3,24'],
    ];

    protected const ATURAN_PENGHASILAN = [
        ['maks' => 1000000, 'skor' => 100, 'label' => '≤ Rp 1.000.000'],
        ['maks' => 2000000, 'skor' => 90,  'label' => 'Rp 1.000.001 – 2.000.000'],
        ['maks' => 3000000, 'skor' => 80,  'label' => 'Rp 2.000.001 – 3.000.000'],
        ['maks' => 4000000, 'skor' => 70,  'label' => 'Rp 3.000.001 – 4.000.000'],
        ['maks' => 5000000, 'skor' => 60,  'label' => 'Rp 4.000.001 – 5.000.000'],
        ['maks' => 7500000, 'skor' => 40,  'label' => 'Rp 5.000.001 – 7.500.000'],
    ];

    protected const SKOR_PRESTASI = [
        'Internasional'  => 100,
        'Nasional'       => 85,
        'Provinsi'       => 70,
        'Kota/Kabupaten' => 55,
        'Kampus'         => 40,
        'Tidak ada'      => 0,
    ];

    protected const SKOR_SEMESTER = [3 => 100, 4 => 90, 5 => 80, 6 => 70, 7 => 60, 8 => 50];

    protected const STATUS_SLUG = [
        'Diterima'    => 'diterima',
        'Cadangan'    => 'cadangan',
        'Tidak Layak' => 'tidak-layak',
    ];

    /* ---------- Konversi kriteria menjadi skor 0-100 ---------- */

    protected function skorIpk(float $ipk): int
    {
        foreach (self::ATURAN_IPK as $aturan) {
            if ($ipk >= $aturan['min']) {
                return $aturan['skor'];
            }
        }
        return 0;
    }

    protected function skorPenghasilan(int $penghasilan): int
    {
        foreach (self::ATURAN_PENGHASILAN as $aturan) {
            if ($penghasilan <= $aturan['maks']) {
                return $aturan['skor'];
            }
        }
        return 0;
    }

    protected function skorPrestasi(string $tingkat): int
    {
        return self::SKOR_PRESTASI[$tingkat] ?? 0;
    }

    protected function skorSemester(int $semester): int
    {
        return self::SKOR_SEMESTER[$semester] ?? 0;
    }

    /* ---------- Kelayakan ---------- */

    /** Mengembalikan daftar alasan ketidaklayakan (kosong = layak). */
    protected function alasanTidakLayak(array $calon): array
    {
        $alasan = [];

        if ($calon['ipk'] < self::IPK_MINIMUM) {
            $alasan[] = 'IPK ' . $this->formatIpk($calon['ipk']) . ' di bawah minimum ' . $this->formatIpk(self::IPK_MINIMUM);
        }
        if ($calon['penghasilan'] > self::PENGHASILAN_MAKSIMUM) {
            $alasan[] = 'Penghasilan orang tua ' . $this->formatRupiah($calon['penghasilan'])
                . ' melebihi batas ' . $this->formatRupiah(self::PENGHASILAN_MAKSIMUM);
        }
        if ($calon['semester'] < self::SEMESTER_MINIMUM || $calon['semester'] > self::SEMESTER_MAKSIMUM) {
            $alasan[] = 'Semester ' . $calon['semester'] . ' di luar rentang '
                . self::SEMESTER_MINIMUM . '–' . self::SEMESTER_MAKSIMUM;
        }

        return $alasan;
    }

    /* ---------- Penanganan skor sama ---------- */

    /** Menentukan kriteria pembeda antara dua calon yang skor akhirnya sama. */
    protected function penentuSeri(array $atas, array $bawah): string
    {
        if ($atas['ipk'] !== $bawah['ipk']) {
            return 'IPK lebih tinggi';
        }
        if ($atas['skor']['prestasi'] !== $bawah['skor']['prestasi']) {
            return 'skor prestasi lebih tinggi';
        }
        if ($atas['penghasilan'] !== $bawah['penghasilan']) {
            return 'penghasilan orang tua lebih rendah';
        }
        return 'urutan abjad nama';
    }

    /* ---------- Proses utama ---------- */

    /**
     * Mengolah seluruh data: skor, kelayakan, peringkat, dan status.
     *
     * @return array{semua: array, peringkat: array, tidak_layak: array, ringkasan: array}
     */
    protected function olahSemua(): array
    {
        $semua = [];

        foreach (CalonPenerima::semua() as $calon) {
            $skor = [
                'ipk'         => $this->skorIpk($calon['ipk']),
                'penghasilan' => $this->skorPenghasilan($calon['penghasilan']),
                'prestasi'    => $this->skorPrestasi($calon['tingkat_prestasi']),
                'semester'    => $this->skorSemester($calon['semester']),
            ];

            // Total poin dihitung dengan bilangan bulat agar perbandingan skor sama akurat.
            $totalPoin = 0;
            $kontribusi = [];
            $kontribusiFormat = [];
            foreach (self::BOBOT as $kriteria => $bobot) {
                $totalPoin += $skor[$kriteria] * $bobot;
                $kontribusi[$kriteria] = $skor[$kriteria] * $bobot / 100;
                $kontribusiFormat[$kriteria] = number_format($kontribusi[$kriteria], 2, ',', '.');
            }

            $alasan = $this->alasanTidakLayak($calon);

            $semua[$calon['id']] = $calon + [
                'skor'               => $skor,
                'kontribusi'         => $kontribusi,
                'kontribusi_format'  => $kontribusiFormat,
                'total_poin'         => $totalPoin,
                'skor_akhir'         => $totalPoin / 100,
                'skor_akhir_format'  => number_format($totalPoin / 100, 2, ',', '.'),
                'layak'              => $alasan === [],
                'alasan'             => $alasan,
                'ipk_format'         => $this->formatIpk($calon['ipk']),
                'penghasilan_format' => $this->formatRupiah($calon['penghasilan']),
                'peringkat'          => null,
                'status'             => 'Tidak Layak',
                'status_slug'        => 'tidak-layak',
                'catatan_seri'       => null,
            ];
        }

        // Pisahkan yang layak lalu urutkan: skor akhir, IPK, prestasi, penghasilan (lebih rendah), nama.
        $layak = array_values(array_filter($semua, fn ($c) => $c['layak']));
        usort($layak, fn ($a, $b) =>
            [$b['total_poin'], $b['ipk'], $b['skor']['prestasi'], $a['penghasilan'], $a['nama']]
            <=>
            [$a['total_poin'], $a['ipk'], $a['skor']['prestasi'], $b['penghasilan'], $b['nama']]
        );

        $seriDiBatasKuota = false;

        foreach ($layak as $i => $calon) {
            $status = ($i < self::KUOTA) ? 'Diterima' : 'Cadangan';
            $id = $calon['id'];

            $semua[$id]['peringkat'] = $i + 1;
            $semua[$id]['status'] = $status;
            $semua[$id]['status_slug'] = self::STATUS_SLUG[$status];

            // Cek skor sama dengan tetangga (sebelum/sesudah).
            $sebelum = $layak[$i - 1] ?? null;
            $sesudah = $layak[$i + 1] ?? null;

            if ($sesudah && $sesudah['total_poin'] === $calon['total_poin']) {
                $semua[$id]['catatan_seri'] = 'Skor sama dengan ' . $sesudah['nama']
                    . '; unggul karena ' . $this->penentuSeri($calon, $sesudah) . '.';
            } elseif ($sebelum && $sebelum['total_poin'] === $calon['total_poin']) {
                $semua[$id]['catatan_seri'] = 'Skor sama dengan ' . $sebelum['nama']
                    . '; ' . $sebelum['nama'] . ' di atas karena ' . $this->penentuSeri($sebelum, $calon) . '.';
            }
        }

        // Skor sama tepat di batas kuota (peringkat 5 dan 6).
        if (isset($layak[self::KUOTA - 1], $layak[self::KUOTA])
            && $layak[self::KUOTA - 1]['total_poin'] === $layak[self::KUOTA]['total_poin']) {
            $seriDiBatasKuota = true;
        }

        $peringkat = array_map(fn ($c) => $semua[$c['id']], $layak);
        $tidakLayak = array_values(array_filter($semua, fn ($c) => ! $c['layak']));

        $jumlahLayak = count($peringkat);
        $rataIpk = $jumlahLayak > 0
            ? array_sum(array_column($peringkat, 'ipk')) / $jumlahLayak
            : 0;

        $ringkasan = [
            'total'              => count($semua),
            'layak'              => $jumlahLayak,
            'tidak_layak'        => count($tidakLayak),
            'diterima'           => min(self::KUOTA, $jumlahLayak),
            'cadangan'           => max(0, $jumlahLayak - self::KUOTA),
            'kuota'              => self::KUOTA,
            'rata_ipk_layak'     => $this->formatIpk($rataIpk),
            'seri_di_batas_kuota' => $seriDiBatasKuota,
        ];

        return [
            'semua'       => array_values($semua),
            'peringkat'   => $peringkat,
            'tidak_layak' => $tidakLayak,
            'ringkasan'   => $ringkasan,
        ];
    }

    /** Data aturan untuk halaman kriteria (hanya data tampilan, tanpa perhitungan). */
    protected function dataKriteria(): array
    {
        return [
            'bobot'              => self::BOBOT,
            'kuota'              => self::KUOTA,
            'aturan_ipk'         => self::ATURAN_IPK,
            'aturan_penghasilan' => self::ATURAN_PENGHASILAN,
            'skor_prestasi'      => self::SKOR_PRESTASI,
            'skor_semester'      => self::SKOR_SEMESTER,
            'syarat'             => [
                'IPK minimal ' . $this->formatIpk(self::IPK_MINIMUM),
                'Penghasilan orang tua maksimal ' . $this->formatRupiah(self::PENGHASILAN_MAKSIMUM) . ' per bulan',
                'Semester aktif ' . self::SEMESTER_MINIMUM . ' sampai ' . self::SEMESTER_MAKSIMUM,
            ],
        ];
    }

    /* ---------- Format ---------- */

    protected function formatIpk(float $ipk): string
    {
        return number_format($ipk, 2, ',', '.');
    }

    protected function formatRupiah(int $nilai): string
    {
        return 'Rp ' . number_format($nilai, 0, ',', '.');
    }
}
