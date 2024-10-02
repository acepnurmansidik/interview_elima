<?php

use App\Http\Controllers\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function (){
    Route::get('/pegawai', [Absensi::class, 'index']);
});