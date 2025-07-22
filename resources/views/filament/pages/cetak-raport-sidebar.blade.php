<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-6 space-y-3">
            <x-filament::button
                wire:click.prevent="cetakCover"
                color="primary"
                type="button"
            >
                Cetak Cover
            </x-filament::button>

            <x-filament::button
                wire:click.prevent="cetakDataDiri"
                color="primary"
                type="button"
            >
                Cetak Data Diri
            </x-filament::button>

            <x-filament::button
                wire:click.prevent="cetakRaport"
                color="primary"
                type="button"
            >
                Cetak Raport
            </x-filament::button>

            <x-filament::button
                wire:click.prevent="cetakPengesahan"
                color="primary"
                type="button"
            >
                Cetak Pengesahan
            </x-filament::button>


        </div>
        
    </form>
</x-filament::page>
