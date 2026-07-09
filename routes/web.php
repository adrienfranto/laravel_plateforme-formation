<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CentreController;

Route::get('/', function () { return redirect('/login'); });

// Connexions rapides démo
Route::get('/login/apprenant', function () {
    \Illuminate\Support\Facades\Auth::login(\App\Models\Compte::where('prenom', 'Alice')->first());
    return redirect('/dashboard');
});
Route::get('/login/formateur', function () {
    \Illuminate\Support\Facades\Auth::login(\App\Models\Compte::where('prenom', 'Jean')->first());
    return redirect('/dashboard');
});

// Auth
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [CompteController::class, 'login']);
Route::post('/logout', [CompteController::class, 'logout'])->name('logout');

// Inscription (register)
Route::get('/register', function () {
    $roles = \App\Models\Role::all();
    return view('auth.register', compact('roles'));
})->name('register');
Route::post('/comptes', [CompteController::class, 'store']);

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/comptes', [CompteController::class, 'index'])->name('comptes.index');
    Route::post('/comptes/{id}/roles', [CompteController::class, 'attachRole']);
    
    Route::resource('centres', CentreController::class)->except(['show', 'edit', 'update']);
    Route::resource('formations', FormationController::class);
    Route::post('/formations/{formation}/inscriptions', [InscriptionController::class, 'store']);
    Route::post('/formations/{formation}/cloturer', [FormationController::class, 'cloturer']);
});

// Vérification publique des certificats
Route::get('/verify/{uuid}', [VerificationController::class, 'show']);
