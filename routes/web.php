<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\CertificatController;
use App\Http\Controllers\ParrainageController;

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

    Route::get('/mes-certificats', [CertificatController::class, 'index'])->name('certificats.index');
    Route::get('/certificats/{certificat}', [CertificatController::class, 'show'])->name('certificats.show');
    Route::post('/inscriptions/{inscription}/note', [\App\Http\Controllers\NoteController::class, 'store'])->name('notes.store');
    Route::resource('parrainages', ParrainageController::class)->only(['index', 'store']);
});

// Vérification publique des certificats
Route::get('/verify', [VerificationController::class, 'index'])->name('verify.index');
Route::post('/verify/search', [VerificationController::class, 'search'])->name('verify.search');
Route::get('/verify/{uuid}', [VerificationController::class, 'show'])->name('verify.show');
