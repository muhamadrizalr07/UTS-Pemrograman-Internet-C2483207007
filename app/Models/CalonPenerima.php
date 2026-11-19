<?php

namespace App\Models;

/**
 * Model data calon penerima beasiswa.
 * Sesuai ketentuan UTS, data disimpan sebagai array PHP (tanpa database).
 */
class CalonPenerima
{
    public static function semua(): array
    {
        return [
            ['id' => 1,  'nim' => '2301001', 'nama' => 'Aulia Rahmawati',  'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 5, 'ipk' => 3.92, 'penghasilan' => 1800000, 'tingkat_prestasi' => 'Nasional',      'prestasi' => 'Juara 2 Lomba Karya Tulis Ilmiah Nasional'],
            ['id' => 2,  'nim' => '2301002', 'nama' => 'Budi Santoso',     'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 5, 'ipk' => 3.78, 'penghasilan' => 2500000, 'tingkat_prestasi' => 'Provinsi',      'prestasi' => 'Juara 1 Lomba Web Design Tingkat Provinsi'],
            ['id' => 3,  'nim' => '2301003', 'nama' => 'Citra Lestari',    'prodi' => 'Pendidikan Matematika',          'semester' => 3, 'ipk' => 3.85, 'penghasilan' => 3500000, 'tingkat_prestasi' => 'Kota/Kabupaten', 'prestasi' => 'Juara 3 Olimpiade Matematika Kota'],
            ['id' => 4,  'nim' => '2301004', 'nama' => 'Dimas Pratama',    'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 7, 'ipk' => 3.45, 'penghasilan' => 1200000, 'tingkat_prestasi' => 'Nasional',      'prestasi' => 'Finalis Kompetisi Pemrograman Nasional'],
            ['id' => 5,  'nim' => '2301005', 'nama' => 'Eka Wulandari',    'prodi' => 'Pendidikan Bahasa Inggris',      'semester' => 5, 'ipk' => 3.60, 'penghasilan' => 4800000, 'tingkat_prestasi' => 'Kampus',        'prestasi' => 'Juara 2 Debat Bahasa Inggris Antar Fakultas'],
            ['id' => 6,  'nim' => '2301006', 'nama' => 'Fajar Nugraha',    'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 4, 'ipk' => 3.95, 'penghasilan' => 900000,  'tingkat_prestasi' => 'Tidak ada',     'prestasi' => '-'],
            ['id' => 7,  'nim' => '2301007', 'nama' => 'Gita Permata',     'prodi' => 'Pendidikan Biologi',             'semester' => 6, 'ipk' => 3.30, 'penghasilan' => 2000000, 'tingkat_prestasi' => 'Provinsi',      'prestasi' => 'Juara Harapan Lomba Karya Ilmiah Remaja Provinsi'],
            ['id' => 8,  'nim' => '2301008', 'nama' => 'Hendra Gunawan',   'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 5, 'ipk' => 2.90, 'penghasilan' => 1500000, 'tingkat_prestasi' => 'Internasional', 'prestasi' => 'Peserta Kompetisi Robotik Internasional'],
            ['id' => 9,  'nim' => '2301009', 'nama' => 'Intan Maharani',   'prodi' => 'Pendidikan Matematika',          'semester' => 5, 'ipk' => 3.70, 'penghasilan' => 8500000, 'tingkat_prestasi' => 'Nasional',      'prestasi' => 'Juara 3 Olimpiade Sains Nasional'],
            ['id' => 10, 'nim' => '2301010', 'nama' => 'Joko Prasetyo',    'prodi' => 'Pendidikan Biologi',             'semester' => 9, 'ipk' => 3.80, 'penghasilan' => 2200000, 'tingkat_prestasi' => 'Provinsi',      'prestasi' => 'Juara 2 Lomba Poster Ilmiah Provinsi'],
            ['id' => 11, 'nim' => '2301011', 'nama' => 'Kartika Dewi',     'prodi' => 'Pendidikan Bahasa Inggris',      'semester' => 2, 'ipk' => 3.88, 'penghasilan' => 2800000, 'tingkat_prestasi' => 'Kampus',        'prestasi' => 'Juara 1 Story Telling Tingkat Kampus'],
            ['id' => 12, 'nim' => '2301012', 'nama' => 'Lukman Hakim',     'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 6, 'ipk' => 3.55, 'penghasilan' => 3200000, 'tingkat_prestasi' => 'Kota/Kabupaten', 'prestasi' => 'Juara 2 Lomba Desain Poster Kota'],
            ['id' => 13, 'nim' => '2301013', 'nama' => 'Maya Anggraini',   'prodi' => 'Pendidikan Bahasa Inggris',      'semester' => 4, 'ipk' => 3.75, 'penghasilan' => 1900000, 'tingkat_prestasi' => 'Kampus',        'prestasi' => 'Juara 1 Lomba Pidato Tingkat Kampus'],
            ['id' => 14, 'nim' => '2301014', 'nama' => 'Naufal Ramadhan',  'prodi' => 'Pendidikan Matematika',          'semester' => 8, 'ipk' => 3.40, 'penghasilan' => 2600000, 'tingkat_prestasi' => 'Provinsi',      'prestasi' => 'Juara 3 Lomba Matematika Provinsi'],
            ['id' => 15, 'nim' => '2301015', 'nama' => 'Putri Ayu',        'prodi' => 'Pendidikan Biologi',             'semester' => 3, 'ipk' => 3.65, 'penghasilan' => 5500000, 'tingkat_prestasi' => 'Provinsi',      'prestasi' => 'Juara 2 Lomba Karya Tulis Provinsi'],
            ['id' => 16, 'nim' => '2301016', 'nama' => 'Rizky Firmansyah', 'prodi' => 'Pendidikan Teknologi Informasi', 'semester' => 4, 'ipk' => 3.30, 'penghasilan' => 950000,  'tingkat_prestasi' => 'Provinsi',      'prestasi' => 'Juara 2 Hackathon Tingkat Provinsi'],
        ];
    }
}
