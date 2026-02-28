<x-filament::page>

    {{ $this->form }}

    @if($santriList)
        <div class="mt-6 space-y-4">

            @foreach($santriList as $santri)
                <div class="p-4 bg-white rounded-xl shadow flex justify-between items-center">
                    
                    <div class="font-semibold">
                        {{ $santri['nama_santri'] }}
                    </div>

                    <div class="flex gap-2">

                        <x-filament::button
                            wire:click="cetakCover({{ $santri['id'] }})"
                            size="sm"
                        >
                            Cover
                        </x-filament::button>

                        <x-filament::button
                            wire:click="cetakDataDiri({{ $santri['id'] }})"
                            size="sm"
                        >
                            Data Diri
                        </x-filament::button>

                        <x-filament::button
                            wire:click="cetakRaport({{ $santri['id'] }})"
                            size="sm"
                            color="primary"
                        >
                            Raport
                        </x-filament::button>

                        <x-filament::button
                            wire:click="cetakPengesahan({{ $santri['id'] }})"
                            size="sm"
                            color="success"
                        >
                            Pengesahan
                        </x-filament::button>

                    </div>
                </div>
            @endforeach

        </div>
    @endif


    {{-- SCRIPT BUKA TAB BARU --}}
    <script>
        window.addEventListener('open-new-tab', event => {
            window.open(event.detail.url, '_blank');
        });
    </script>

</x-filament::page>