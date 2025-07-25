<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\Widget;

class CalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.calendar-widget';

    protected static ?string $heading = 'Kalender Bulan Ini';

    protected static ?int $sort = 2;

    public function getCalendarData(): array
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        $startDay = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endDay = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $calendar = [];
        $day = $startDay->copy();

        while ($day->lte($endDay)) {
            $calendar[] = [
                'date' => $day->copy(),
                'isToday' => $day->isToday(),
                'isCurrentMonth' => $day->month === $today->month,
            ];
            $day->addDay();
        }

        return [
            'calendar' => $calendar,
            'monthName' => $today->translatedFormat('F Y'),
        ];
    }
}
