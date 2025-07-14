<!-- resources/views/print/raport_full.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Raport Santri</title>
  <style>
    @page { size: A4 portrait; margin: 0; }
    html, body { width: 210mm; height: 297mm; }
  </style>
  @vite('resources/css/app.css')
</head>
<body class="bg-white text-[8.5pt] leading-tight p-4">
  <div class="border border-black h-full flex flex-col">
    <!-- Kop Lembaga (Logo + Teks) -->
    <div class="items-center justify-center border-b border-black h-[90px]">
      <img src="{{ asset('images/copPSM.png') }}" class="" alt="Logo"/>
    </div>

    <!-- Judul -->
    <h3 class="text-center font-bold text-[11pt] my-2 mt-20 underline">LAPORAN HASIL BELAJAR SANTRI</h3>

    <!-- Info Santri -->
<table class="w-full mb-1 text-[10pt] table-fixed">
    <colgroup>
        <col class="w-24" /> <!-- label kiri -->
        <col class="w-3" />  <!-- : -->
        <col class="w-[180px]" /> <!-- isian kiri -->
        <col class="w-40" />  <!-- GAP TENGAH -->
        <col class="w-16" /> <!-- label kanan -->
        <col class="w-3" />  <!-- : -->
        <col /> <!-- isian kanan -->
    </colgroup>
<tbody>
  <tr>
    <td class="pl-2">Nama Santri</td><td>:</td><td>&nbsp;</td>
    <td></td>
    <td class="pl-2">Kelas</td><td>:</td><td>&nbsp;</td>
  </tr>
  <tr>
    <td class="pl-2">No. Induk</td><td>:</td><td>&nbsp;</td>
    <td></td>
    <td class="pl-2">Semester</td><td>:</td><td>&nbsp;</td>
  </tr>
  <tr>
    <td class="pl-2">Alamat</td><td>:</td><td>&nbsp;</td>
    <td></td>
    <td class="pl-2">Tahun Pelajaran</td><td>:</td><td>&nbsp;</td>
  </tr>

</tbody>


    <table class="w-full text-[8pt] text-center">
        {{-- <colgroup>
            <col class="w-4" />        <!-- No -->
            <col class="w-72" /> <!-- Mata Pelajaran -->
            <col class="w-10" />       <!-- Angka -->
            <col class="w-28" />       <!-- Huruf -->
            <col class="w-10" />       <!-- KKM -->
            <col class="w-28" />       <!-- كتابةً -->
            <col class="w-10" />       <!-- رقمًا --> 
            <col class="w-20" />        <!-- Bahasa Arab -->
        </colgroup> --}}
  <!-- Header -->
        <thead>
            <tr>
            <th colspan="2" rowspan="2" class="border border-black">Mata Pelajaran</th>
            <th colspan="2" class="border border-black">Hasil Tes</th> 
            <th rowspan="2" class="w-10 border border-black">KKM</th>
            <th colspan="2" class="border border-black">الدّرجاتُ النّهائية</th>
            <th colspan="2" rowspan="2" class="w-6 border border-black">الموادّ الدراسيّة</th>
            
            </tr>
            <tr>
            <th class="w-10 border-r border-b border-black">Angka</th>
            <th class="w-10 border-r border-b border-black">Huruf</th>
            <th class="w-10 border-r border-b border-black">كتابةً</th>
            <th class="w-10 border-r border-b border-black">رقماً</th>
            </tr>
        </thead>

        <!-- Bagian A – Tertulis -->
        <tbody class="text-[8pt]">
            <colgroup>
                    <col class="w-7" />        <!-- No -->
                    <col class="w-52" /> <!-- Mata Pelajaran -->
                    <col class="w-10" />       <!-- Angka -->
                    <col class="w-28" />       <!-- Huruf -->
                    <col class="w-10" />       <!-- KKM -->
                    <col class="w-28" />       <!-- كتابةً -->
                    <col class="w-10" />       <!-- رقمًا --> 
                    <col class="w-52" />        <!-- Bahasa Arab -->
                    <col class="w-7" />         <!--nomor-->
                </colgroup>

            <tr>
                <td class="border border-black font-bold">A</td>
                <td class="border border-black text-left font-bold">Tertulis</td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td dir="rtl" class="border border-black text-right font-bold">مكتوب</td>
                <td class="border border-black text-left"></td>
            </tr>

            <tr>
                <td class="border border-black">1</td>
                <td class="border border-black text-left">Fiqih</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black">1</td>
                <td class="border border-black text-left">Fiqih</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black">1</td>
                <td class="border border-black text-left">Fiqih</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black">1</td>
                <td class="border border-black text-left">Fiqih</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black font-bold">B</td>
                <td class="border border-black text-left font-bold">Hafalan dan Membaca</td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td dir="rtl" class="border border-black text-right"></td>
                <td class="border border-black text-left"></td>
            </tr>

            <tr>
                <td class="border border-black">2</td>
                <td class="border border-black text-left">Juz Amma</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black">2</td>
                <td class="border border-black text-left">Juz Amma</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black font-bold">C</td>
                <td class="border border-black text-left font-bold">Ekstrakulikuler</td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td class="border border-black"></td>
                <td dir="rtl" class="border border-black text-right"></td>
                <td class="border border-black text-left"></td>
            </tr>

            <tr>
                <td class="border border-black">3</td>
                <td class="border border-black text-left">Hadrah</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black">2</td>
                <td class="border border-black text-left">Juz Amma</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td class="border border-black">2</td>
                <td class="border border-black text-left">Juz Amma</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>
            

            

            <!-- Ringkasan -->
            <tr class="border-b border-black">
            <td colspan="2" class="text-left px-1 border border-black">JUMLAH</td>
            <td>‑</td>
            <td class="border border-black">-</td>
            <td rowspan="3" class="border border-black border-b-0">-</td>
            <td dir="rtl" class="border border-black text-right">-</td>
            <td class="border border-black">-</td>
            <td dir="rtl" class="border border-black text-right">-</td>
            <td class="border border-black">-</td>
            </tr>

            <tr class="border-b border-black">
                <td colspan="2" class="text-left px-1 border border-black">RATA-RATA</td>
                <td>‑</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

            <tr>
                <td colspan="2" class="text-left px-1 border border-black">RANKING</td>
                <td class="border border-black">‑</td>
                <td class="border border-black"></td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
                <td dir="rtl" class="border border-black text-right">-</td>
                <td class="border border-black">-</td>
            </tr>

        </tbody>
    </table>


    <!-- Kepribadian & Absensi -->
    <div class="grid grid-cols-2 gap-2 mt-2 text-[8pt]">
      <table class="border border-black text-center">
        <thead><tr><th colspan="2" class="border-b border-black">KEPRIBADIAN</th></tr></thead>
        <tbody>
          <tr><td class="text-left px-1 border-r border-black">Akhlak</td><td>‑</td></tr>
          <tr><td class="text-left px-1 border-r border-black">Kerajinan</td><td>‑</td></tr>
          <tr><td class="text-left px-1 border-r border-black">Kedisiplinan</td><td>‑</td></tr>
          <tr><td class="text-left px-1 border-r border-black">Kerajinan</td><td>‑</td></tr>
        </tbody>
      </table>
      <table class="border border-black text-center">
        <thead><tr><th colspan="2" class="border-b border-black">Absensi</th></tr></thead>
        <tbody>
          <tr><td class="text-left px-1 border-r border-black">Sakit</td><td>‑</td></tr>
          <tr><td class="text-left px-1 border-r border-black">Izin</td><td>‑</td></tr>
          <tr><td class="text-left px-1 border-r border-black">Alpa</td><td>‑</td></tr>
          <tr><td class="text-left px-1 border-r border-black">Jumlah</td><td>‑</td></tr>
        </tbody>
      </table>
    </div>

    <p class="text-[7pt] mt-1">Raport Semester … ( … )</p>
  </div>
</body>
</html>
