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
    <div class="flex-1 p-4">
      <!-- A. Identitas Santri -->
      <div class="space-y-1">
        <div class="font-semibold">A&nbsp;&nbsp;Identitas Santri</div>
        <table class="w-full border-collapse">
          <tbody>
            <tr><td class="w-6">1.</td><td class="w-56">Nama Lengkap</td><td class="w-3 text-center">:</td><td>............................................</td></tr>
            <tr><td>2.</td><td>No. Induk</td><td>:</td><td>............................................</td></tr>
            <tr><td>3.</td><td>NISN</td><td>:</td><td>............................................</td></tr>
            <tr><td>4.</td><td>NIK</td><td>:</td><td>............................................</td></tr>
            <tr><td>5.</td><td>Jenis Kelamin</td><td>:</td><td>Laki‑Laki / Perempuan</td></tr>
            <tr><td>6.</td><td>Tempat Lahir</td><td>:</td><td>............................................</td></tr>
            <tr><td>7.</td><td>Tanggal Lahir</td><td>:</td><td>............................................</td></tr>
            <tr><td>8.</td><td>Agama</td><td>:</td><td>............................................</td></tr>
            <tr><td>9.</td><td>Anak Ke‑</td><td>:</td><td>............................................</td></tr>
            <tr><td>10.</td><td>Sekolah Asal</td><td>:</td><td>............................................</td></tr>
            <tr><td>11.</td><td>Diterima Sebagai</td><td>:</td><td>............................................</td></tr>
            <tr><td>12.</td><td>Diterima Tanggal</td><td>:</td><td>............................................</td></tr>
            <tr><td>13.</td><td>Kelas</td><td>:</td><td>............................................</td></tr>
            <tr><td>14.</td><td>Rombel</td><td>:</td><td>............................................</td></tr>
            <tr class="align-top">
              <td>15.</td><td>Alamat</td><td>:</td>
              <td>
                <div class="grid grid-cols-2 gap-x-2">
                  <div>Dusun&nbsp;:&nbsp;....................</div>
                  <div>Kabupaten&nbsp;:&nbsp;....................</div>
                  <div>Desa&nbsp;:&nbsp;....................</div>
                  <div>Provinsi&nbsp;:&nbsp;....................</div>
                  <div>Kecamatan&nbsp;:&nbsp;....................</div>
                  <div>KodePos&nbsp;:&nbsp;....................</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- B. Data Ayah -->
      <div class="mt-4 space-y-1">
        <div class="font-semibold">B&nbsp;&nbsp;Data Ayah</div>
        <table class="w-full border-collapse"><tbody>
          <tr><td class="w-6">16.</td><td class="w-56">Nama Ayah</td><td class="w-3">:</td><td>............................................</td></tr>
          <tr><td>17.</td><td>Tahun Lahir</td><td>:</td><td>............................................</td></tr>
          <tr><td>18.</td><td>NIK</td><td>:</td><td>............................................</td></tr>
          <tr><td>19.</td><td>Pendidikan</td><td>:</td><td>............................................</td></tr>
          <tr><td>20.</td><td>Pekerjaan</td><td>:</td><td>............................................</td></tr>
          <tr><td>21.</td><td>Penghasilan</td><td>:</td><td>............................................</td></tr>
        </tbody></table>
      </div>

      <!-- C. Data Ibu -->
      <div class="mt-4 space-y-1">
        <div class="font-semibold">C&nbsp;&nbsp;Data Ibu</div>
        <table class="w-full border-collapse"><tbody>
          <tr><td class="w-6">22.</td><td class="w-56">Nama Ibu</td><td class="w-3">:</td><td>............................................</td></tr>
          <tr><td>23.</td><td>Tahun Lahir</td><td>:</td><td>............................................</td></tr>
          <tr><td>24.</td><td>NIK</td><td>:</td><td>............................................</td></tr>
          <tr><td>25.</td><td>Pendidikan</td><td>:</td><td>............................................</td></tr>
          <tr><td>26.</td><td>Pekerjaan</td><td>:</td><td>............................................</td></tr>
          <tr><td>27.</td><td>Penghasilan</td><td>:</td><td>............................................</td></tr>
        </tbody></table>
      </div>

      <!-- D. Data Kontak -->
      <div class="mt-4 space-y-1">
        <div class="font-semibold">D&nbsp;&nbsp;Data Kontak</div>
        <table class="w-full border-collapse"><tbody>
          <tr><td class="w-6">28.</td><td class="w-56">Telepon</td><td class="w-3">:</td><td>............................................</td></tr>
          <tr><td>29.</td><td>Email</td><td>:</td><td>............................................</td></tr>
        </tbody></table>
      </div>

      <!-- Signature & Photo -->
      <div class="flex justify-between mt-8 mr-24">
        <div class="border border-gray-400 w-[90px] h-[120px] flex items-center justify-center text-[8pt] leading-tight text-center ml-6">Photo<br/>3 × 4</div>
        <div class="text-center text-[9pt]">
          WayKanan, .....................................<br/>
          Kepala Madrasah<br/><br/><br/>
          <span class="font-semibold underline">SYAMSUL HADI, S.Pd</span><br/>
          NIP.
        </div>
      </div>
    </div>
  </div>
</body>
</html>
