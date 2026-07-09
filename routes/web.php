<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CompteController;

Route::get('/', function () { return view('welcome'); });

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

Route::post('/comptes', [CompteController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::post('/comptes/{id}/roles', [CompteController::class, 'attachRole']);
    Route::resource('formations', FormationController::class);
    Route::post('/formations/{formation}/inscriptions', [InscriptionController::class, 'store']);
    Route::post('/formations/{formation}/cloturer', [FormationController::class, 'cloturer']);
});

Route::get('/verify/{uuid}', [VerificationController::class, 'show']);
