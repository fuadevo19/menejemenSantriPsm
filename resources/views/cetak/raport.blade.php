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
    <div class="items-center justify-center  h-[90px] pt-0.3 px-0.3">
      <img src="{{ asset('images/copPSM.png') }}"  alt="Logo"/>
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
        <span class="font-semibold flex-1">{{ $santri->nama_santri ?? '-' }}</span>
      </div>
      <div class="flex">
        <span class="min-w-[80px]">No. Induk</span>
        <span class="w-2 text-center">:</span>
        <span class="flex-1">{{ $santri->no_induk ?? '-' }}</span>
      </div>
      <div class="flex">
        <span class="min-w-[80px]">Alamat</span>
        <span class="w-2 text-center">:</span>
        <span class="flex-1">{{ $santri->alamat->desa ?? '-' }}</span>
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
        <span class="flex-1">{{ $semester->nama_semester ?? '-' }} ({{$semesterLabel ?? '-'}})</span>
      </div>
      <div class="flex">
        <span class="min-w-[90px]">Tahun Pelajaran</span>
        <span class="w-2 text-center">:</span>
        <span class="flex-1">{{ $tahunAjaranLabel ?? '-'}}</span>
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
              <td class="border border-black font-bold py-0.5">A</td>
              <td class="border border-black text-left font-bold py-0.5 pl-1">Tertulis</td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right font-bold py-0.5 pr-1">مكتوب</td>
              <td class="border border-black text-left py-0.5"></td>
            </tr>

            @foreach ($nilaiTertulis as $index => $nilai)
            <tr>
                <td class="border border-black py-0.5">{{ $index + 1 ?? '-'}}</td>
                <td class="border border-black text-left py-0.5 pl-1">{{ $nilai->mataPelajaran->nama_pelajaran ?? '-' }}</td>
                <td class="border border-black py-0.5 font-bold">{{$nilai->nilai ?? '-'}}</td>
                <td class="border border-black py-0.5 text-left pl-1 text-[8pt] max-w-[120px] break-words leading-tight">{{ $nilai->terbilang ?? '-'}}</td>
                <td class="border border-black py-0.5 font-bold">60</td>
                <td dir="rtl" class="border border-black py-0.5 text-right pr-1 text-[8pt] max-w-[120px] break-words leading-tight">{{$nilai->terbilang_arab ?? '-'}}</td>
                <td class="border border-black py-0.5 font-bold">
                    {{ $convertToArabic($nilai->nilai) ?? '-'}}
                </td>
                <td dir="rtl" class="border border-black text-right py-0.5 pr-1">{{ $nilai->mataPelajaran->nama_pelajaran_arab ?? '-' }}</td>
                <td class="border border-black py-0.5">
                    {{ $convertToArabic($index + 1) ?? '-'}}
                </td>
            </tr>
            @endforeach

            <tr>
              <td class="border border-black py-0.5 h-4.5"></td>
              <td class="border border-black text-left py-0.5 pl-1"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5 text-left pl-1"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right py-0.5 pr-1"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right py-0.5 pr-1"></td>
              <td class="border border-black py-0.5"></td>
           </tr>

           <tr>
              <td class="border border-black font-bold py-0.5">B</td>
              <td class="border border-black text-left font-bold py-0.5 pl-1">Hafalan dan Membaca</td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right font-bold py-0.5 pr-1">حفظ ويقرأ</td>
              <td class="border border-black text-left py-0.5"></td>
            </tr>

            @foreach ($nilaiHafalanMembaca as $index => $nilai)
            <tr>
                <td class="border border-black py-0.5">{{ $index + 1 }}</td>
                <td class="border border-black text-left py-0.5 pl-1">{{ $nilai->mataPelajaran->nama_pelajaran ?? '-' }}</td>
                <td class="border border-black py-0.5 font-bold">{{$nilai->nilai ?? '-'}}</td>
                <td class="border border-black py-0.5 text-left pl-1 text-[8pt] max-w-[120px] break-words leading-tight">{{ $nilai->terbilang }}</td>
                <td class="border border-black py-0.5 font-bold">60</td>
                <td dir="rtl" class="border border-black py-0.5 text-right pr-1 text-[8pt] max-w-[120px] break-words leading-tight">{{$nilai->terbilang_arab ?? '-'}}</td>
                <td class="border border-black py-0.5 font-bold">
                    {{ $convertToArabic($nilai->nilai) }}
                </td>
                <td dir="rtl" class="border border-black text-right py-0.5 pr-1">{{ $nilai->mataPelajaran->nama_pelajaran_arab ?? '-' }}</td>
                <td class="border border-black py-0.5">
                    {{ $convertToArabic($index + 1) }}
                </td>
            </tr>
            @endforeach


            <tr>
              <td class="border border-black py-0.5 h-4.5"></td>
              <td class="border border-black text-left py-0.5 pl-1"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5 text-left pl-1"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right py-0.5 pr-1"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right py-0.5 pr-1"></td>
              <td class="border border-black py-0.5"></td>
           </tr>


            <tr>
              <td class="border border-black font-bold py-0.5">C</td>
              <td class="border border-black text-left font-bold py-0.5 pl-1">Ekstrakulikuler</td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right font-bold py-0.5 pr-1">مكتوب</td>
              <td class="border border-black text-left py-0.5"></td>
            </tr>

            @foreach ($nilaiEkstrakurikuler as $index => $nilai)
            <tr>
                <td class="border border-black py-0.5">{{ $index + 1 }}</td>
                <td class="border border-black text-left py-0.5 pl-1">{{ $nilai->mataPelajaran->nama_pelajaran ?? '-' }}</td>
                <td class="border border-black py-0.5 font-bold">{{$nilai->nilai ?? '-'}}</td>
                <td class="border border-black py-0.5 text-left pl-1 text-[8pt] max-w-[120px] break-words leading-tight">{{ $nilai->terbilang }}</td>
                <td class="border border-black py-0.5 font-bold">60</td>
                <td dir="rtl" class="border border-black py-0.5 text-right pr-1 text-[8pt] max-w-[120px] break-words leading-tight">{{$nilai->terbilang_arab ?? '-'}}</td>
                <td class="border border-black py-0.5 font-bold">
                    {{ $convertToArabic($nilai->nilai) }}
                </td>
                <td dir="rtl" class="border border-black text-right py-0.5 pr-1">{{ $nilai->mataPelajaran->nama_pelajaran_arab ?? '-' }}</td>
                <td class="border border-black py-0.5">
                    {{ $convertToArabic($index + 1) }}
                </td>
            </tr>
            @endforeach

           <tr>
              <td class="border border-black py-0.5 h-4.5"></td>
              <td class="border border-black text-left py-0.5 pl-1"></td>
              <td class="border border-black py-0.5"></td>
              <td class="border border-black py-0.5 text-left pl-1"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right py-0.5 pr-1"></td>
              <td class="border border-black py-0.5"></td>
              <td dir="rtl" class="border border-black text-right py-0.5 pr-1"></td>
              <td class="border border-black py-0.5"></td>
           </tr>
            

            <!-- Ringkasan -->
            <!-- JUMLAH -->
          <tr class="border-b border-black">
            <td colspan="2" class="text-left px-1 border border-black py-0.5 font-bold">JUMLAH</td>
            <td class="py-0.5 font-bold">{{$totalNilai}}</td>
            <td class="border border-black py-0.5 text-left pl-1 text-[8pt] max-w-[120px] break-words leading-tight">
              {{ $terbilang }}
            </td>

            <!-- sel kosong untuk rowspan -->
            <td rowspan="3" class="border border-black border-b-0 py-0.5"></td>

            <td dir="rtl" class="border border-black text-right py-0.5 pr-1 text-[8pt] max-w-[120px] break-words leading-tight">
                {{ $terbilangArab }}
            </td>
            <td class="border border-black py-0.5 font-bold">{{$convertToArabic($totalNilai)}}</td>
            <td colspan="2" dir="rtl" class="border border-black text-right py-0.5 pr-1 font-bold">الجملة</td>
            
          </tr>

          <!-- RATA‑RATA -->
          <tr class="border-b border-black">
            <td colspan="2" class="text-left px-1 border border-black py-0.5 font-bold">RATA‑RATA</td>
            <td class="py-0.5 font-bold">{{$rataRata}}</td>
            <td class="border border-black py-0.5 text-left pl-1 text-[8pt] max-w-[120px] break-words leading-tight">
              {{ $rataRataIndo }}
            </td>

            <td dir="rtl" class="border border-black text-right py-0.5 pr-1 text-[8pt] max-w-[120px] break-words leading-tight">
                {{ $rataRataArab }}
            </td>
            <td class="border border-black py-0.5 font-bold">{{$convertToArabic($rataRata)}}</td>
            <td colspan="2" dir="rtl" class="border border-black text-right py-0.5 pr-1 font-bold">معدل</td>
            
          </tr>

          <!-- RANKING -->
          <tr>
            <td colspan="2" class="text-left px-1 border border-black py-0.5 font-bold">RANKING</td>
            <td class="border border-black py-0.5 font-bold" >{{ $ranking }}</td>
            <td class="border border-black py-0.5 text-left pl-1 font-bold">Dari {{$jumlahSantri}} Santri</td>

            <td dir="rtl" class="border border-black text-right py-0.5 pr-1 text-[8pt] max-w-[120px] break-words leading-tight font-bold">من {{$terbilangArabJumlahSantri}} طالب</td>
            <td class="border border-black py-0.5 font-bold">{{$convertToArabic($jumlahSantri)}}</td>
            <td colspan="2" dir="rtl" class="border border-black text-right py-0.5 pr-1 font-bold">الدرجة</td>
            
          </tr>


        </tbody>
    </table>


    <!-- Kepribadian & Absensi -->
    <!-- Grid 2 kolom (jika diperlukan di layout luar) -->
    <div class="grid grid-cols-2 gap-10 mt-2 text-[9pt]">
      <table class="text-[9pt] border border-black table-fixed mr-0.5">
  <thead>
    <tr class="divide-x divide-black">
      <th class=" text-center border-b border-black w-43 py-0.5 font-bold">
        KEPRIBADIAN
      </th>
      <th class=" text-center border-b border-black py-0.5 font-bold" dir="rtl">
        احوال الطالب
      </th>
    </tr>
  </thead>

  <tbody>
    <!-- Baris 1 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Akhlaq</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{ $kepribadian->akhlaq ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">أخلاق</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$convertToArabic($kepribadian->akhlaq ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>

    <!-- Baris 2 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Kerajinan</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$kepribadian->kerajinan ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">حرفة</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$convertToArabic($kepribadian->kerajinan ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>

    <!-- Baris 3 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Kedisiplinan</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$kepribadian->kedisiplinan ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">تأديب</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$convertToArabic($kepribadian->kedisiplinan ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>

    <!-- Baris 4 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Kerapihan</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$kepribadian->kerapihan ??'-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">نظافة</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$convertToArabic($kepribadian->kerapihan ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>
  </tbody>
</table>


      <!--KOLOM 2-->
      <table class="w-full text-[9pt] border border-black table-fixed">
  <thead>
    <tr class="divide-x divide-black">
      <th class=" text-center border-b border-black py-0.5 font-bold">
        ABSENSI
      </th>
      <th class="font-bold text-center border-b border-black py-0.5" dir="rtl">
        كشف الغياب
      </th>
    </tr>
  </thead>

  <tbody>
    <!-- Baris 1 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Sakit</span>
          <span class="text-center">:</span>
          <span class="text-center ">{{$absensi->sakit ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">بعذر</span>
          <span class="text-center">:</span>
          <span class="text-center">{{$convertToArabic($absensi->sakit ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>

    <!-- Baris 2 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Izin</span>
          <span class="text-center">:</span>
          <span class="text-center">{{$absensi->izin ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">بغير عذر</span>
          <span class="text-center">:</span>
          <span class="text-center">{{$convertToArabic($absensi->izin ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>

    <!-- Baris 3 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap">Alpa</span>
          <span class="text-center">:</span>
          <span class="text-center">{{$absensi->alpha ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap">بغير بيان</span>
          <span class="text-center">:</span>
          <span class="text-center">{{$convertToArabic($absensi->alpha ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>

    <!-- Baris 4 -->
    <tr class="divide-x divide-black">
      <td class="pl-2 border-b border-black py-0.5">
        <div class="grid grid-cols-3">
          <span class="whitespace-nowrap font-bold">Jumlah</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$totalAbsensi ?? '-'}}</span>
        </div>
      </td>
      <td class="pr-2 border-b border-black py-0.5" dir="rtl">
        <div class="grid grid-cols-3">
          <span class="text-right whitespace-nowrap font-bold">الجملة</span>
          <span class="text-center">:</span>
          <span class="text-center font-bold">{{$convertToArabic($totalAbsensi ?? 0) ?? '-'}}</span>
        </div>
      </td>
    </tr>
  </tbody>
</table>
</div>


    <p class="absolute bottom-0 left-0 text-[8pt] my-2 ml-5">
    Raport {{ $semester->nama_semester ?? '-' }} ({{$semesterLabel ?? '-'}})
    </p>
</div>
    <button 
    onclick="window.print()" 
    class="fixed top-4 right-4 z-50 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow print:hidden"
    >
    🖨️ Print A4
    </button>
</body>
</html>
