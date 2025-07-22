<?php

use App\Models\Santri;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaportController;

Route::get('/', function () {

    return redirect()->route('filament.admin.auth.login');

});

Route::get('/datadiri/{santri}', [RaportController::class, 'dataDiri']);


Route::get('/cover/{santri}', [RaportController::class, 'cover']);


Route::get('/raport/{santri}/{semester}', [RaportController::class, 'show']);


Route::get('/pengesahan/{santri}/{semester}', [RaportController::class, 'pengesahan']);
