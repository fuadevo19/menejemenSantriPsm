<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\KepribadianSantri;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class RaportController extends Controller
{
    public function show(Santri $santri, $semester )
{   
     // Ambil data semester dari route
    $semester = Semester::findOrFail($semester);
    $semesterLabel = $semester->semester;

    // Ambil tahun ajaran dari relasi Semester
    $tahunAjaranId = $semester->tahun_ajaran_id;
    $tahunAjaranLabel = $semester->tahunAjaran?->label;

    // Ambil kelas dari data nilai
    $kelasId = Nilai::where('santri_id', $santri->id)
        ->where('semester_id', $semester->id)
        ->value('kelas_id');

    $kelas = Kelas::find($kelasId);

    // Ambil semua nilai santri berdasarkan semester yang ada di route
    $nilaiTertulis = $santri->nilai()
        ->with('mataPelajaran')
        ->whereHas('mataPelajaran', fn($q) => $q->where('kategori', 'Tertulis'))
        ->where('semester_id', $semester->id)
        ->orderBy('mata_pelajaran_id')
        ->get();

    $nilaiEkstrakurikuler = $santri->nilai()
        ->with('mataPelajaran')
        ->whereHas('mataPelajaran', fn($q) => $q->where('kategori', 'Ekstrakurikuler'))
        ->where('semester_id', $semester->id)
        ->orderBy('mata_pelajaran_id')
        ->get();

    $nilaiHafalanMembaca = $santri->nilai()
        ->with('mataPelajaran')
        ->whereHas('mataPelajaran', fn($q) => $q->where('kategori', 'Hafalan dan Membaca'))
        ->where('semester_id', $semester->id)
        ->orderBy('mata_pelajaran_id')
        ->get();

    // Format nilai ke dalam terbilang Indo & Arab
    foreach ([$nilaiTertulis, $nilaiEkstrakurikuler, $nilaiHafalanMembaca] as $collection) {
        $collection->transform(function ($item) {
            $item->terbilang = $this->terbilangIndo($item->nilai);
            $item->terbilang_arab = $this->terbilangArab($item->nilai);
            return $item;
        });
    }

    // Konversi angka ke angka arab (fungsi bantu)
    $convertToArabic = fn($number) => implode('', array_map(fn($d) => ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'][$d], str_split((string)$number)));

    // Total nilai & rata-rata
    $totalNilai = $nilaiTertulis->sum('nilai') + $nilaiHafalanMembaca->sum('nilai') + $nilaiEkstrakurikuler->sum('nilai');
    $totalItem = $nilaiTertulis->count() + $nilaiHafalanMembaca->count() + $nilaiEkstrakurikuler->count();
    $rataRata = $totalItem > 0 ? round($totalNilai / $totalItem, 2) : 0;

    $rataRataIndo = $this->terbilangIndo($rataRata);
    $rataRataArab = $this->terbilangArab($rataRata);
    $terbilang = $this->terbilangUtama($totalNilai);
    $terbilangArab = $this->terbilangArab($totalNilai);

    // Ambil salah satu nilai untuk santri ini di semester tersebut (agar dapat kelas_id dan tahun_ajaran_id)
    $nilaiSantri = Nilai::where('santri_id', $santri->id)
        ->where('semester_id', $semester->id)
        ->first();

    $ranking = null;
    $jumlahSantri = 0;

    if ($nilaiSantri) {
        $kelasId = $nilaiSantri->kelas_id;
        $tahunAjaranId = $nilaiSantri->tahun_ajaran_id;

        // Ambil total nilai tiap santri dalam satu kelas, semester, dan tahun ajaran
        $rankingData = Nilai::selectRaw('santri_id, SUM(nilai) as total_nilai')
            ->where('kelas_id', $kelasId)
            ->where('semester_id', $semester->id)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->groupBy('santri_id')
            ->orderByDesc('total_nilai')
            ->get();

        $jumlahSantri = $rankingData->count();

        // Cari ranking santri
        $ranking = $rankingData->search(fn($item) => $item->santri_id == $santri->id);
        $ranking = $ranking !== false ? $ranking + 1 : null;
    }

    // Konversi ke Arab
    $terbilangArabJumlahSantri = $this->terbilangArab($jumlahSantri);

    // Kepribadian
    $kepribadian = KepribadianSantri::where('santri_id', $santri->id)
        ->where('semester_id', $semester->id)
        ->first();

    // Absensi
    $absensi = Absensi::where('santri_id', $santri->id)
        ->where('semester_id', $semester->id)
        ->first() ?? new Absensi(['sakit' => 0, 'izin' => 0, 'alpha' => 0]);

    $totalAbsensi = $absensi->sakit + $absensi->izin + $absensi->alpha;

    return view('raport', compact(
        'santri', 'semester', 'tahunAjaranLabel',
        'nilaiTertulis', 'nilaiHafalanMembaca', 'nilaiEkstrakurikuler',
        'convertToArabic', 'totalNilai', 'terbilang', 'terbilangArab',
        'rataRata', 'rataRataArab', 'rataRataIndo',
        'jumlahSantri', 'ranking', 'terbilangArabJumlahSantri',
        'kepribadian', 'absensi', 'totalAbsensi', 'semesterLabel', 'kelas'
    ));
}

 public function terbilangIndo($number)
{
    $angka = [
        "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam",
        "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
    ];

    // Pisahkan bilangan bulat dan desimal
    $parts = explode('.', (string)$number);
    $integerPart = intval($parts[0]);
    $decimalPart = isset($parts[1]) ? $parts[1] : null;

    // Proses bilangan bulat
    $result = $this->terbilangUtama($integerPart);

    // Proses bilangan desimal (jika ada)
    if ($decimalPart !== null) {
        $result .= ' Koma';
        $digits = str_split($decimalPart);
        foreach ($digits as $digit) {
            $result .= ' ' . $angka[intval($digit)];
        }
    }

    return trim($result);
}

// Fungsi bantu untuk bagian bilangan bulat
private function terbilangUtama($number)
{
    $angka = [
        "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam",
        "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
    ];

    if ($number < 12) {
        return $angka[$number];
    } elseif ($number < 20) {
        return $angka[$number - 10] . " Belas";
    } elseif ($number < 100) {
        return $angka[intval($number / 10)] . " Puluh " . $this->terbilangUtama($number % 10);
    } elseif ($number < 200) {
        return "Seratus " . $this->terbilangUtama($number - 100);
    } elseif ($number < 1000) {
        return $angka[intval($number / 100)] . " Ratus " . $this->terbilangUtama($number % 100);
    } elseif ($number < 2000) {
        return "Seribu " . $this->terbilangUtama($number - 1000);
    } elseif ($number < 10000) {
        return $angka[intval($number / 1000)] . " Ribu " . $this->terbilangUtama($number % 1000);
    } elseif ($number < 1000000) {
        return $this->terbilangUtama(intval($number / 1000)) . " Ribu " . $this->terbilangUtama($number % 1000);
    } else {
        return $number; // Bisa ditambah dukungan juta, milyar, dll
    }
}

//terbilang bahasa arab

function terbilangArab($number)
{
    $angka = [
        "", "واحد", "اثنان", "ثلاثة", "أربعة", "خمسة",
        "ستة", "سبعة", "ثمانية", "تسعة", "عشرة", "أحد عشر"
    ];

    if (!is_numeric($number)) return $number;

    $number = floatval($number);

    if (floor($number) != $number) {
        $integer = floor($number);
        $decimal = explode(".", number_format($number, 2, '.', ''))[1];
        return $this-> terbilangArab($integer) . " فاصلة " . implode(' ', array_map(function ($digit) use ($angka) {
            return $angka[$digit];
        }, str_split($decimal)));
    }

    if ($number < 12) {
        return $angka[$number];
    } elseif ($number < 20) {
        return $angka[$number - 10] . " عشر";
    } elseif ($number < 100) {
        return $angka[intval($number / 10)] . "ون" . " و" . $angka[$number % 10];
    } elseif ($number < 200) {
        return "مائة و" . $this-> terbilangArab($number - 100);
    } elseif ($number < 1000) {
        return $angka[intval($number / 100)] . " مائة " . $this-> terbilangArab($number % 100);
    } elseif ($number < 2000) {
        return "ألف و" . $this-> terbilangArab($number - 1000);
    } elseif ($number < 1000000) {
        return $this-> terbilangArab(intval($number / 1000)) . " ألف " . $this-> terbilangArab($number % 1000);
    } else {
        return $number;
    }
}


public function pengesahan(Santri $santri, $semester)
{
    
    // Ambil data semester dari route
    $semester = Semester::findOrFail($semester);
    $semesterLabel = $semester->semester;

    // Ambil data nilai berdasarkan santri dan semester
    $nilai = Nilai::where('santri_id', $santri->id)
        ->where('semester_id', $semester->id)
        ->first();

    // Ambil tahun ajaran dan labelnya
    $tahunAjaranId = $nilai?->tahun_ajaran_id;
    $tahunAjaranLabel = $nilai?->tahunAjaran?->label;

    // Ambil kelas dari nilai
    $kelasId = $nilai?->kelas_id;
    $kelas = $kelasId ? Kelas::find($kelasId) : null;

    // Ambil data santri
    $namaSantri = $santri->nama_santri ?? '-';
    $noInduk = $santri->no_induk ?? '-';
    $alamatDesa = $santri->alamat->desa ?? '-'; // Pastikan kolom `desa` ada di tabel `santris`

    // Ambil wali kelas dari relasi kelas
    $waliKelas = $kelas?->wali_kelas ?? '-';
    
    // Ambil kepala madrasah dan pengasuh
    $tahunAjaran = $nilai?->tahunAjaran;
    $kepalaMadrasah = $tahunAjaran?->kepala_madrasah ?? '-';
    $pengasuh = $tahunAjaran?->pengasuh ?? '-';
    
    
    // Kirim ke view
    return view('pengesahan', compact(
        'semesterLabel',
        'semester',
        'tahunAjaranLabel',
        'kelas',
        'namaSantri',
        'noInduk',
        'alamatDesa',
        'waliKelas', 'kepalaMadrasah', 'pengasuh'
    ));
}
}


