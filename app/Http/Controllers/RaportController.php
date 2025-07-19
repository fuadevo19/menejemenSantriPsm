<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

class RaportController extends Controller
{
    public function show(Santri $santri)
{
    // Ambil nilai terbaru dengan relasi semester, tahun_ajaran, dan mata_pelajaran
    $nilaiTerbaru = $santri->nilai()
        ->with(['semester', 'tahunAjaran', 'mataPelajaran'])
        ->latest()
        ->first();

    // Ambil semester dan tahun ajaran
    $semester = $nilaiTerbaru?->semester;
    $tahunAjaranLabel = $nilaiTerbaru?->tahunAjaran?->label ?? '-';

    // Ambil semua nilai santri untuk semester yang sama, dan pelajaran kategori Tertulis
    $nilaiTertulis = $santri->nilai()
        ->with('mataPelajaran')
        ->whereHas('mataPelajaran', function ($query) {
            $query->where('kategori', 'Tertulis');
        })
        ->where('semester_id', $semester?->id)
        ->orderBy('mata_pelajaran_id')
        ->get();

    // Ambil nilai kategori Ekstrakurikuler
    $nilaiEkstrakurikuler = $santri->nilai()
        ->with('mataPelajaran')
        ->whereHas('mataPelajaran', function ($query) {
            $query->where('kategori', 'Ekstrakurikuler');
        })
        ->where('semester_id', $semester?->id)
        ->orderBy('mata_pelajaran_id')
        ->get();

    // Ambil nilai kategori "Hafalan dan Membaca"
    $nilaiHafalanMembaca = $santri->nilai()
        ->with('mataPelajaran')
        ->whereHas('mataPelajaran', function ($query) {
            $query->where('kategori', 'Hafalan dan Membaca');
        })
        ->where('semester_id', $semester?->id)
        ->orderBy('mata_pelajaran_id')
        ->get();
    

    //fungsi untuk niai terbilang
    $nilaiTertulis = $nilaiTertulis->map(function ($item) {
    $item->terbilang = $this->terbilangIndo($item->nilai);
    $item->terbilang_arab = $this->terbilangArab($item->nilai); // arab
    return $item;
    });

    $nilaiHafalanMembaca = $nilaiHafalanMembaca->map(function ($item) {
        $item->terbilang = $this->terbilangIndo($item->nilai);
        $item->terbilang_arab = $this->terbilangArab($item->nilai);
        return $item;
    });

    $nilaiEkstrakurikuler = $nilaiEkstrakurikuler->map(function ($item) {
        $item->terbilang = $this->terbilangIndo($item->nilai);
        $item->terbilang_arab = $this->terbilangArab($item->nilai);
        return $item;
    });


    // Fungsi bantu untuk ubah angka ke angka Arab
    $convertToArabic = function ($number) {
        $arabicDigits = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        return implode('', array_map(function ($digit) use ($arabicDigits) {
            return $arabicDigits[$digit];
        }, str_split((string) $number)));
    };

    $totalNilai = $nilaiTertulis->sum('nilai') 
             + $nilaiHafalanMembaca->sum('nilai') 
             + $nilaiEkstrakurikuler->sum('nilai');

    //hitung rata rata
    $totalItem = $nilaiTertulis->count() 
            + $nilaiHafalanMembaca->count() 
            + $nilaiEkstrakurikuler->count();

    $rataRata = $totalItem > 0 ? round($totalNilai / $totalItem, 2) : 0;

    $rataRataIndo = $this->terbilangIndo($rataRata);
    $rataRataArab = $this->terbilangArab($rataRata);
             
    $terbilang = $this->terbilangUtama($totalNilai);
    $terbilangArab = $this->terbilangArab($totalNilai);
    

    //hitung ranking
    // Ambil data kelas dan tahun ajaran dari santri yang sedang ditampilkan
    $kelasId = $santri->kelas_id;
    $tahunAjaranId = $santri->nilai->first()->tahun_ajaran_id ?? null;

    if ($tahunAjaranId) {
        // Ambil semua total nilai santri di kelas dan tahun ajaran yang sama
        $rankingData = \App\Models\Nilai::selectRaw('santri_id, SUM(nilai) as total_nilai')
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->groupBy('santri_id')
            ->orderByDesc('total_nilai')
            ->get();

        // Hitung jumlah santri yang dihitung
        $jumlahSantri = $rankingData->count();

        // Ambil ranking dari santri yang sedang tampil
        $ranking = $rankingData->search(function ($item) use ($santri) {
            return $item->santri_id == $santri->id;
        });

        $ranking = $ranking !== false ? $ranking + 1 : null;
            } else {
                $ranking = null;
                $jumlahSantri = 0;
            }

    $terbilangArabJumlahSantri = $this->terbilangArab($jumlahSantri);

    // Kirim ke view
    return view('raport', [
        'santri' => $santri,
        'semester' => $semester,
        'tahunAjaranLabel' => $tahunAjaranLabel,
        'nilaiTertulis' => $nilaiTertulis,
        'nilaiHafalanMembaca' => $nilaiHafalanMembaca, // dikirim ke blade
        'nilaiEkstrakurikuler'=> $nilaiEkstrakurikuler,
        'convertToArabic' => $convertToArabic,

        
        'totalNilai' => $totalNilai,
        'terbilang' => $terbilang,
        'terbilangArab' => $terbilangArab,
        'rataRata' => $rataRata,
        'rataRataArab' => $rataRataArab,
        'rataRataIndo' => $rataRataIndo,
        'jumlahSantri' => $jumlahSantri,
        'ranking' => $ranking,
        'terbilangArabJumlahSantri' => $terbilangArabJumlahSantri,
    ]);
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



}

