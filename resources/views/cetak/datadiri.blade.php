<!-- resources/views/print/santri_identity_static.blade.php -->
<!--
  Fixed-layout A4 (210×297 mm) for "KETERANGAN TENTANG DIRI SANTRI"
  – Belum terhubung database; berisi teks placeholder (titik/garis) persis seperti contoh gambar.
  – Semua ukuran & margin dioptimalkan untuk dicetak pada kertas A4 portrait.
  – Saat siap integrasi, ganti placeholder "........" dengan Blade expression  sesuai kebutuhan.
-->
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keterangan Tentang Diri Santri</title>
  <style>
    @page { size: A4 portrait; margin: 0; }
    html,body{ width:210mm; height:297mm; }
  </style>
  @vite('resources/css/app.css')
</head>
<body class="h-full bg-white text-[10pt] leading-relaxed p-6">
  <div class="border border-black h-full flex flex-col">
    <h2 class="text-center font-bold text-[12pt] py-2 ">KETERANGAN TENTANG DIRI SANTRI</h2>

    <!-- CONTENT -->
    <div class="flex-1 pb-4 px-10">
      <!-- A. Identitas Santri -->
      <div class="space-y-1">
        <div class="font-semibold">A&nbsp;&nbsp;Identitas Santri</div>
        <table class="w-full border-collapse">
          <tbody>
            <tr><td class="w-8 pl-4">1.</td><td class="w-30">Nama Lengkap</td><td class="w-3">:</td><td>{{ $santri->nama_santri ?? '-' }}</td></tr>
            <tr><td class="pl-4">2.</td><td>No. Induk</td><td>:</td><td>{{ $santri->no_induk ?? '-' }}</td></tr>
            <tr><td class="pl-4">3.</td><td>NISN</td><td>:</td><td>{{ $santri->nisn ?? '-' }}</td></tr>
            <tr><td class="pl-4">4.</td><td>NIK</td><td>:</td><td>{{ $santri->nik ?? '-' }}</td></tr>
            <tr><td class="pl-4">5.</td><td>Jenis Kelamin</td><td>:</td><td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : ($santri->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td></tr>
            <tr><td class="pl-4">6.</td><td>Tempat Lahir</td><td>:</td><td>{{ $santri->tempat_lahir ?? '-' }}</td></tr>
            <tr><td class="pl-4">7.</td><td>Tanggal Lahir</td><td>:</td><td>{{ $santri->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="pl-4">8.</td><td>Agama</td><td>:</td><td>{{ $santri->agama ?? '-' }}</td></tr>
            <tr><td class="pl-4">9.</td><td>Anak Ke‑</td><td>:</td><td>{{ $santri->anak_ke ?? '-' }}</td></tr>
            <tr><td class="pl-2">10.</td><td>Sekolah Asal</td><td>:</td><td>{{ $santri->sekolah_asal ?? '-' }}</td></tr>
            <tr><td class="pl-2">11.</td><td>Diterima Sebagai</td><td>:</td><td>{{ $santri->diterima_sebagai ?? '-' }}</td></tr>
            <tr><td class="pl-2">12.</td><td>Diterima Tanggal</td><td>:</td><td>{{ $santri->tanggal_diterima ?? '-' }}</td></tr>
            <tr><td class="pl-2">13.</td><td>Kelas</td><td>:</td><td>{{ $santri->kelas->nama_kelas ?? '-' }}</td></tr>
            <tr><td class="pl-2">14.</td><td>Rombel</td><td>:</td><td>{{ $santri->rombel ?? '-' }}</td></tr>
            <tr><td class="pl-2">15.</td><td>Alamat</td><td>:</td></tr>
          </tbody>
        </table>
        <td>
          <div class="grid grid-cols-2 gap-x-8">
            <div class="ml-19">
              <div>-Dusun <span class="ml-7 mr-2">:</span >{{ $santri->alamat->dusun ?? '-' }}</div>
              <div class="">-Desa<span class="ml-10 mr-2">:</span>{{ $santri->alamat->desa ?? '-' }}</div>
              <div class="">-Kecamatan<span class="ml-1 mr-2">:</span >{{ $santri->alamat->kecamatan ?? '-' }}</div>
            </div>
            <div class="ml-10">
              <div>-Kabupaten<span class="ml-1 mr-2">:</span >{{ $santri->alamat->kabupaten ?? '-' }}</div>
              <div class="">-Provinsi<span class="ml-5 mr-2">:</span>{{ $santri->alamat->provinsi ?? '-' }}</div>
              <div class="">-KodePos<span class="ml-4 mr-2">:</span>{{ $santri->alamat->kode_pos ?? '-' }}</div>
            </div>
          </div>
        </td>

      </div>

      <!-- B. Data Ayah -->
      <div class="mt-2 space-y-1">
        <div class="font-semibold -ml-2">B&nbsp;&nbsp;Data Ayah</div>
        <table class="w-full border-collapse"><tbody>
          <tr><td class="w-8 pl-2">16.</td><td class="w-30">Nama Ayah</td><td class="w-3">:</td><td>{{ $santri->ayah->nama ?? '-' }}</td></tr>
          <tr><td class="pl-2">17.</td><td>Tahun Lahir</td><td>:</td><td>{{ $santri->ayah->tahun_lahir ?? '-' }}</td></tr>
          <tr><td class="pl-2">18.</td><td>NIK</td><td>:</td><td>{{ $santri->ayah->nik ?? '-' }}</td></tr>
          <tr><td class="pl-2">19.</td><td>Pendidikan</td><td>:</td><td>{{ $santri->ayah->pendidikan ?? '-' }}</td></tr>
          <tr><td class="pl-2">20.</td><td>Pekerjaan</td><td>:</td><td>{{ $santri->ayah->pekerjaan ?? '-' }}</td></tr>
          <tr><td class="pl-2">21.</td><td>Penghasilan</td><td>:</td><td>{{ $santri->ayah->penghasilan ?? '-' }}</td></tr>
        </tbody></table>
      </div>

      <!-- C. Data Ibu -->
      <div class="mt-4 space-y-1">
        <div class="font-semibold -ml-2.5">C&nbsp;&nbsp;Data Ibu</div>
        <table class="w-full border-collapse"><tbody>
          <tr><td class="w-8 pl-1.5">22.</td><td class="w-30">Nama Ibu</td><td class="w-3">:</td><td>{{ $santri->ibu->nama ?? '-' }}</td></tr>
          <tr><td class="pl-1.5">23.</td><td>Tahun Lahir</td><td>:</td><td>{{ $santri->ibu->tahun_lahir ?? '-' }}</td></tr>
          <tr><td class="pl-1.5">24.</td><td>NIK</td><td>:</td><td>{{ $santri->ibu->nik ?? '-' }}</td></tr>
          <tr><td class="pl-1.5">25.</td><td>Pendidikan</td><td>:</td><td>{{ $santri->ibu->pendidikan ?? '-' }}</td></tr>
          <tr><td class="pl-1.5">26.</td><td>Pekerjaan</td><td>:</td><td>{{ $santri->ibu->pekerjaan ?? '-' }}</td></tr>
          <tr><td class="pl-1.5">27.</td><td>Penghasilan</td><td>:</td><td>{{ $santri->ibu->penghasilan ?? '-' }}</td></tr>
        </tbody></table>
      </div>

      <!-- D. Data Kontak -->
      <div class="mt-4 space-y-1">
        <div class="font-semibold -ml-3.5">D&nbsp;&nbsp;Data Kontak</div>
        <table class="w-full border-collapse"><tbody>
          <tr><td class="w-7 pl-1">28.</td><td class="w-30">Telepon</td><td class="w-3">:</td><td> {{ 
                        $santri->ayah->telepon 
                        ?? $santri->ibu->telepon 
                        ?? '-' 
                    }}</td></tr>
          <tr><td class="pl-1">29.</td><td>Email</td><td>:</td><td> {{ 
                        $santri->ayah->email 
                        ?? $santri->ibu->email 
                        ?? '-' 
                    }}</td></tr>
        </tbody></table>
      </div>

      <!-- Signature & Photo -->
      <div class="flex justify-between mt-8 mr-24 ml-1">
        <div class="border border-gray-400 w-[90px] h-[120px] flex items-center justify-center text-[8pt] leading-tight text-center ml-6">Photo<br/>3 × 4</div>
        <div class="text-center text-[10pt] ml-10">
          <span class="ml-11" >Way Kanan, <input 
      type="text" 
      placeholder="Edit: Tanggal" 
      class="w-auto border-gray-400 outline-none" 
      oninput="resizeInput(this)" 
      size="1"
    ><br/>
  </span></span>
          Kepala Madrasah<br/><br/><br/>
          <span class="font-semibold underline">{{ $tahunAjaran->kepala_madrasah ?? '-' }}</span><br/>
          NIP.
        </div>
      </div>
    </div>
  </div>
  <button 
    onclick="window.print()" 
    class="fixed top-4 right-4 z-50 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow print:hidden"
    >
    🖨️ Print A4
    </button>
    <script>
  function resizeInput(input) {
    input.size = input.value.length > 0 ? input.value.length : 1;
  }
</script>
</body>
</html>
