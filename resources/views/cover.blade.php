<!-- resources/views/print/cover.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cover Raport Santri</title>
  <style>
    @page { size: A4 portrait; margin: 0; }
    html, body { width: 210mm; height: 297mm; }
  </style>
  @vite('resources/css/app.css')
</head>
<body class="bg-white text-[11pt] text-black p-8 flex flex-col justify-center items-center">
  <div class="w-full h-full border border-black flex flex-col justify-center items-center text-center px-8 py-2 ">
    <h1 class="text-xl font-bold mb-2 ">BUKU</h1>
    <h2 class="text-xl font-bold mb-2">LAPORAN HASIL BELAJAR SANTRI</h2>
    <h2 class="text-xl font-bold mb-10">MADRASAH DINIYAH</h2>

    <!-- Logo -->
    <img src="{{asset('images/logoPSM.png')}}" alt="Logo Madrasah" class="my-4 w-50 h-50 object-contain" />

    <!-- Informasi Lembaga -->
    <div class="text-[10pt] leading-tight mt-24 mb-6">
      <p class="mb-1.5"><strong>PONDOK PESANTREN SABILIL MUQORROBIN</strong></p>
      <p class="mb-1.5"><strong>MADRASAH DINIYAH PONDOK PESANTREN SABILIL MUQORROBIN</strong></p>
      <p class="mb-1.5"><strong>NPSN : 510018080022</strong></p>
      <p class="mb-1.5">Jl. Santri 01, Suka Agung, Buay Bahuga, Way Kanan, Lampung 34767</p>
      <p class="mb-1.5">Telp.: 082280307067, Email: pondokpsm98@gmail.com Website: https://mipsmsa.psmeducation.id</p>
    </div>

    <!-- Nama Santri -->
    <div class="mt-10 w-80">
      <div class="text-[10pt] mb-9">NAMA SANTRI</div>
      <h2 class="text-[14pt] font-bold mt-1 uppercase">{{ $santri->nama_santri }}</h2>
      <hr class="w-full border-1">
      <div class="text-[10pt] mt-2">Nomor Induk: {{ $santri->no_induk }}</div>
    </div>
  </div>
</body>
</html>