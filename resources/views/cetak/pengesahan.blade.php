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
<div class="border border-black h-full flex flex-col relative">
    <!-- Kop Lembaga (Logo + Teks) -->
    <div class="items-center justify-center h-[90px] px-0.4 py-0.4 ">
    <img src="{{ asset('images/copPSM.png') }}" alt="Logo"/>
    </div>

    <!-- Judul -->
    <h3 class="text-center font-bold text-[14pt] my-2 mt-20">LAPORAN HASIL BELAJAR SANTRI</h3>

    <div class="w-full px-4 py-2 text-[9pt] font-sans">

    <!-- Dua kolom info -->
    <div class="grid grid-cols-2 gap-77 mx-1.5">
        <!-- Kolom Kiri -->
        <div class="space-y-[2px]">
        <div class="flex">
            <span class="min-w-[80px]">Nama Santri</span>
            <span class="w-2 text-center">:</span>
            <span class="font-semibold flex-1">{{$namaSantri}}</span>
        </div>
        <div class="flex">
            <span class="min-w-[80px]">No. Induk</span>
            <span class="w-2 text-center">:</span>
            <span class="flex-1">{{ $noInduk }}</span>
        </div>
        <div class="flex">
            <span class="min-w-[80px]">Alamat</span>
            <span class="w-2 text-center">:</span>
            <span class="flex-1">{{ $alamatDesa }}</span>
        </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="space-y-[2px]">
        <div class="flex">
            <span class="min-w-[90px]">Kelas</span>
            <span class="w-2 text-center">:</span>
            <span class="flex-1">{{ $kelas->nama_kelas ?? '-' }}</span>
        </div>
        <div class="flex">
            <span class="min-w-[90px]">Semester</span>
            <span class="w-2 text-center">:</span>
            <span class="flex-1">{{ $semester->nama_semester ?? '-' }} ({{$semesterLabel}})</span>
        </div>
        <div class="flex">
            <span class="min-w-[90px]">Tahun Pelajaran</span>
            <span class="w-2 text-center">:</span>
            <span class="flex-1">{{ $tahunAjaranLabel}}</span>
        </div>
        </div>
    </div>
    </div>


    <div class="mx-5">
        <table class="w-full text-[9pt] text-center ">
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
            <th colspan="2" rowspan="2" class="border border-black py-0.5">
            Mata Pelajaran
            </th>
            <th colspan="2" class="border border-black py-0.5">
            Hasil Tes
            </th>
            <th rowspan="2" class="w-10 border border-black py-0.5">
            KKM
            </th>
            <th colspan="2" class="border border-black py-0.5" dir="rtl">
             الدرجات العقلية
            </th>
            <th colspan="2" rowspan="2" class="w-6 border border-black py-0.5" dir="rtl">
             المواد الدراسية
            </th>
            </tr>

            <tr>
                <th class="w-10 border-r border-b border-black py-0.5">
                Angka
                </th>
                <th class="w-10 border-r border-b border-black py-0.5">
                Huruf
                </th>
                <th class="w-10 border-r border-b border-black py-0.5" dir="rtl">
                كتابة
                </th>
                <th class="w-10 border-r border-b border-black py-0.5" dir="rtl">
                رقما
                </th>
            </tr>
        </thead>


        <!-- Bagian A – Tertulis -->
        <tbody class="text-[8pt]">
            <colgroup>
                    <col class="w-7" />        <!-- No -->
                    <col class="w-33" /> <!-- Mata Pelajaran -->
                    <col class="w-10" />       <!-- Angka -->
                    <col class="w-28" />       <!-- Huruf -->
                    <col class="w-10" />       <!-- KKM -->
                    <col class="w-28" />       <!-- كتابةً -->
                    <col class="w-10" />       <!-- رقمًا --> 
                    <col class="w-33" />        <!-- Bahasa Arab -->
                    <col class="w-7" />         <!--nomor-->
                </colgroup>

            <tr>
            <td colspan="4" class="border border-black font-bold py-0.5">CATATAN GURU</td>
            <td rowspan="3" class=" py-0.5 "></td>
            <td colspan="4" class="border border-black py-0.5 font-bold">KEPUTUSAN</td>
            </tr>

            <tr>
            <td colspan="4" rowspan="2" class="border border-black px-0.5 h-15 align-top">
                <textarea name="catatan_guru" maxlength="135" class="w-full h-full resize-none outline-none p-1 text-[10pt] italic" placeholder="Edit: Catatan guru..."></textarea>
            </td>
            <td colspan="4" class="border border-black px-0.5 h-10 text-left">Berdasarkan hasil yang dicapai pada {{$semester->nama_semester}} Santri, maka dinyatakan:</td>
            </tr>

            <tr>
            <td colspan="4" class="border border-black py-0.5 text-left px-0.5"><input type="text" placeholder="Edit: Naik Kelas" class="w-25 mr-6 italic"></td>
            </tr>
        </tbody>

        <div class="absolute grid grid-cols-3 gap-10 justify-center text-center mt-42 text-[10pt] w-full px-10 -ml-5">
            <!-- Kolom 1: Orang Tua -->
            <div>
                <div class="font-semibold">Orang Tua/Wali</div>
                <div class="mt-12">.................................</div>
            </div>

            <!-- Kolom 2: Guru Wali Kelas -->
            <div>
                <div class="font-semibold">Guru Wali Kelas</div>
                <div class="mt-12 font-bold underline">{{$waliKelas}}</div>
                <div class="text-xs mt-1">NIP. {{$NIPwaliKelas}}</div>
            </div>

            <!-- Kolom 3: Kepala Madrasah -->
            <div>
                <div class="font-semibold">Kepala Madrasah</div>
                <div class="mt-12 font-bold underline">{{$kepalaMadrasah}}</div>
                <div class="text-xs mt-1">NIP. {{$NIPkepalaMadrasah}}</div>
            </div>
        </div>
        <div class="absolute text-center w-full mt-[18.5rem] text-[10pt] -ml-5">
        <div>
            <div class="font-semibold">Mengetahui, <br><span>Pengasuh</span></div>
            <div class="mt-12 font-bold underline">{{$pengasuh}}</div>
            <div class="text-xs mt-1">NIP. {{$NIPpengasuh}}</div>
        </div>
        </div>
             

        <p class="absolute w-full h-7 text-right mt-[8.25rem] text-[9pt]">
             Way Kanan, <input type="text" placeholder="Edit: Tanggal" class="w-25 mr-6">
        </p>
                
        <p class="absolute bottom-0 left-0 text-[8pt] my-2 ml-5">
        Raport {{ $semester->nama_semester ?? '-' }} ({{$semesterLabel}})
        </p>
    </div>
    
</div>
    <button 
    onclick="window.print()" 
    class="fixed top-4 right-4 z-50 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow print:hidden"
    >
    🖨️ Print A4
    </button>


</body>
</html>
