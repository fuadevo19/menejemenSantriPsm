<x-filament::widget>
    <x-filament::card>
        <div class="text-center text-lg font-semibold mb-4">
            {{ \Carbon\Carbon::today()->locale('id')->translatedFormat('l, d F Y') }}
        </div>

        <div class="grid grid-cols-7 gap-1 text-center text-sm font-medium text-gray-600">
            @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                <div>{{ $day }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1 mt-2 text-center text-sm">
            @foreach ($this->getCalendarData()['calendar'] as $day)
                @php
                    $classes = 'py-1';

                    if (!$day['isCurrentMonth']) {
                        $classes .= ' text-gray-300';
                    } elseif ($day['isToday']) {
                        $classes .= ' bg-blue-500 text-black dark:text-white font-bold rounded-full';
                    }
                @endphp

                <div class="{{ $classes }}">
                    {{ $day['date']->day }}
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
