<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return redirect()->route('filament.admin.auth.login');

});

Route::get('/datadiri', function(){
    return view('datadiri');
});

Route::get('/cover', function(){
    return view('cover');
});

Route::get('/raport', function(){
    return view('raport');
});