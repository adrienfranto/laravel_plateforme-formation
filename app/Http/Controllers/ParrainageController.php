<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Parrainage;
use App\Models\Compte;
use App\Models\Centre;

class ParrainageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Parrainages dont je suis le parrain
        $mesParrainages = Parrainage::where('parrain_id', $user->id)
                                    ->with(['filleul', 'centre'])
                                    ->latest()
                                    ->get();

        // Récupérer la liste des utilisateurs potentiels à parrainer (tous sauf moi-même et les admins éventuels, juste une liste simple ici)
        $comptes = Compte::where('id', '!=', $user->id)->orderBy('prenom')->get();
        $centres = Centre::orderBy('nom')->get();

        return view('parrainages.index', compact('mesParrainages', 'comptes', 'centres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'filleul_id' => 'required|exists:comptes,id|different:parrain_id',
            'centre_id' => 'required|exists:centres,id',
        ]);

        $user = Auth::user();

        if ($user->id == $request->filleul_id) {
            return back()->withErrors(['filleul_id' => 'Vous ne pouvez pas vous parrainer vous-même.']);
        }

        // Check if already parrainé for this centre
        $exists = Parrainage::where('filleul_id', $request->filleul_id)
                            ->where('centre_id', $request->centre_id)
                            ->exists();

        if ($exists) {
            return back()->withErrors(['filleul_id' => 'Cet utilisateur a déjà été parrainé dans ce centre.']);
        }

        Parrainage::create([
            'parrain_id' => $user->id,
            'filleul_id' => $request->filleul_id,
            'centre_id' => $request->centre_id,
            'recompense_declenchee' => false,
        ]);

        return redirect()->route('parrainages.index')->with('success', 'Parrainage enregistré avec succès !');
    }
}
