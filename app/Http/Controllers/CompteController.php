<?php
namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Role;
use App\Http\Requests\StoreCompteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompteController extends Controller {
    public function store(StoreCompteRequest $request) {
        $compte = Compte::create([
            'telephone' => $request->telephone,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'password' => Hash::make($request->password),
        ]);
        
        $compte->roles()->attach($request->role_id);
        
        \Illuminate\Support\Facades\Auth::login($compte);

        return redirect('/formations')->with('success', 'Votre compte a été créé avec succès !');
    }

    public function attachRole(Request $request, $id) {
        $compte = Compte::findOrFail($id);
        $compte->roles()->attach($request->role_id);
        return redirect()->back()->with('success', 'Rôle ajouté');
    }
}
