<?php

use App\Models\Santri;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaportController;

Route::get('/', function () {

    return redirect()->route('filament.admin.auth.login');

});

Route::get('/datadiri/{santri}', function (Santri $santri) {
    $tahunAjaran = TahunAjaran::latest()->first();

    return view('datadiri', compact('santri', 'tahunAjaran'));
});


Route::get('/cover/{santri}', function (Santri $santri) {
    return view('cover', compact('santri'));
});

Route::get('/raport/{santri}', [RaportController::class, 'show']);

Route::get('/pengesahan', function(){
    return view('pengesahan');
});

Route::get('/raport/preview', function () {
    return view('cover'); // Menampilkan resources/views/cover.blade.php
})->name('preview.raport');

Route::get('/preview', function(){
    return view('preview');
});