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
  <div class="w-full h-full border border-black flex flex-col justify-center items-center text-center px-8 py-10">
    <h1 class="text-xl font-bold mb-2 ">BUKU</h1>
    <h2 class="text-xl font-bold mb-2">LAPORAN HASIL BELAJAR SANTRI</h2>
    <h2 class="text-xl font-bold mb-4">MADRASAH DINIYAH</h2>

    <!-- Logo -->
    <img src="" alt="Logo Madrasah" class="my-4 w-40 h-40 object-contain" />

    <!-- Informasi Lembaga -->
    <div class="text-[10pt] leading-tight mt-4 mb-6">
      <strong>PONDOK PESANTREN SABILIL MUQORROBIN</strong><br/>
      MADRASAH DINIYAH PONDOK PESANTREN SABILIL MUQORROBIN<br/>
      <strong>NPSN : 510018080022</strong><br/>
      Jl. Santri 01, Suka Agung, Buay Bahuga, Way Kanan, Lampung, 34767<br/>
      Telp.: 082280307067, Email: pondokpsm98@gmail.com<br/>
      Website: https://mipsmsa.psmeducation.id
    </div>

    <!-- Nama Santri -->
    <div class="mt-8">
      <div class="text-[10pt]">NAMA SANTRI</div>
      <h2 class="text-[14pt] font-bold mt-1 mb-2 uppercase">A. SANUSI RIDWAN</h2>
      <div class="text-[10pt]">Nomor Induk: 2307001/0</div>
    </div>
  </div>
</body>
</html>