<?php

namespace App\Filament\Widgets;

use App\Models\Santri;
use Filament\Widgets\ChartWidget;

class SantriGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Santri Putra & Putri';

    protected static ?int $sort = 1; // Posisi urutan widget

    protected function getData(): array
    {
        $putra = Santri::where('jenis_kelamin', 'L')->count();
        $putri = Santri::where('jenis_kelamin', 'P')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Santri',
                    'data' => [$putra, $putri],
                    'backgroundColor' => ['#3B82F6', '#F472B6'], // biru, pink
                ],
            ],
            'labels' => ['Putra', 'Putri'],
        ];
    }
    protected static ?array $options = [
    'scales' => [
        'x' => [
            'display' => false,
        ],
        'y' => [
            'display' => false,
        ],
    ],
];

    protected function getType(): string
    {
        return 'pie';
    }
}
