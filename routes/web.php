<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/apprenant', function () {
    \Illuminate\Support\Facades\Auth::login(\App\Models\Compte::where('prenom', 'Alice')->first());
    return redirect('/formations');
});
Route::get('/login/formateur', function () {
    \Illuminate\Support\Facades\Auth::login(\App\Models\Compte::where('prenom', 'Jean')->first());
    return redirect('/formations');
});
Route::get('/login', function () {
    return '<div style="font-family:sans-serif; text-align:center; padding:50px;"><h1>Connexion Rapide (Démo)</h1><a href="/login/apprenant" style="display:block;margin:10px;">Connexion Apprenant (Alice)</a><a href="/login/formateur" style="display:block;margin:10px;">Connexion Formateur (Jean)</a></div>';
})->name('login');

Route::middleware('auth')->group(function () {
    Route::resource('formations', \App\Http\Controllers\FormationController::class);
    Route::post('/formations/{formation}/inscriptions', [\App\Http\Controllers\InscriptionController::class, 'store']);
    Route::post('/formations/{formation}/cloturer', [\App\Http\Controllers\FormationController::class, 'cloturer']);
});

// Route publique, sans authentification
Route::get('/verify/{uuid}', [\App\Http\Controllers\VerificationController::class, 'show']);
