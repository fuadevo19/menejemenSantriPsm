<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport Lengkap</title>
    <style>
        @media print {
            .page-break {
                page-break-after: always;
            }
        }

        .section {
            margin-bottom: 40px; /* Untuk tampilan layar biasa */
        }
    </style>
</head>
<body>

    {{-- Cover --}}
    <div class="section page-break">
        @include('cetak.cover', ['santri' => $santri, 'semester' => $semester])
    </div>

    {{-- Data Diri --}}
    <div class="section page-break">
        @include('cetak.datadiri', ['santri' => $santri, 'semester' => $semester])
    </div>

    {{-- Nilai --}}
    <div class="section page-break">
        @include('cetak.raport', ['santri' => $santri, 'semester' => $semester])
    </div>

    {{-- Pengesahan --}}
    <div class="section">
        @include('cetak.pengesahan', ['santri' => $santri, 'semester' => $semester])
    </div>

</body>
</html>
