<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Http\Requests\StoreCompteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompteController extends Controller
{
    /**
     * Inscription : création d'un compte + attribution du rôle + connexion auto
     */
    public function store(StoreCompteRequest $request)
    {
        $compte = Compte::create([
            'telephone' => $request->telephone,
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'password'  => Hash::make($request->password),
        ]);

        $compte->roles()->attach($request->role_id);

        Auth::login($compte);

        return redirect('/formations')->with('success', 'Votre compte a été créé avec succès !');
    }

    /**
     * Connexion : authentification par téléphone + mot de passe
     */
    public function login(Request $request)
    {
        $request->validate([
            'telephone' => 'required|string',
            'password'  => 'required|string',
        ]);

        $compte = Compte::where('telephone', $request->telephone)->first();

        if (! $compte || ! Hash::check($request->password, $compte->password)) {
            return back()
                ->withInput(['telephone' => $request->telephone])
                ->withErrors(['telephone' => 'Téléphone ou mot de passe incorrect.']);
        }

        Auth::login($compte, $request->boolean('remember'));

        return redirect('/formations')->with('success', 'Bienvenue, ' . $compte->prenom . ' !');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Attacher un rôle supplémentaire à un compte
     */
    public function attachRole(Request $request, $id)
    {
        $compte = Compte::findOrFail($id);
        $compte->roles()->attach($request->role_id);
        return redirect()->back()->with('success', 'Rôle ajouté.');
    }
}
