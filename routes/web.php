<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CompteController;

Route::get('/', function () { return redirect('/formations'); });

Route::get('/login/apprenant', function () {
    \Illuminate\Support\Facades\Auth::login(\App\Models\Compte::where('prenom', 'Alice')->first());
    return redirect('/formations');
});
Route::get('/login/formateur', function () {
    \Illuminate\Support\Facades\Auth::login(\App\Models\Compte::where('prenom', 'Jean')->first());
    return redirect('/formations');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    $roles = \App\Models\Role::all();
    return view('auth.register', compact('roles'));
})->name('register');

Route::post('/comptes', [CompteController::class, 'store']);

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/comptes/{id}/roles', [CompteController::class, 'attachRole']);
    Route::resource('formations', FormationController::class);
    Route::post('/formations/{formation}/inscriptions', [InscriptionController::class, 'store']);
    Route::post('/formations/{formation}/cloturer', [FormationController::class, 'cloturer']);
});

Route::get('/verify/{uuid}', [VerificationController::class, 'show']);
