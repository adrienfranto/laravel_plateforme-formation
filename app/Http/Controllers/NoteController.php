<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Enregistrer ou mettre à jour la note d'un apprenant pour une inscription.
     * Seul le formateur de la formation peut noter.
     */
    public function store(Request $request, Inscription $inscription)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est le formateur de cette formation
        abort_unless(
            $user->roles->contains('code', 'formateur') &&
            $inscription->formation->formateur_id === $user->id,
            403,
            'Seul le formateur de cette formation peut attribuer des notes.'
        );

        $request->validate([
            'note'         => 'required|numeric|min:0|max:20',
            'commentaire'  => 'nullable|string|max:500',
        ]);

        $inscription->update([
            'note'        => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', "Note de {$request->note}/20 enregistrée pour {$inscription->compte->prenom} {$inscription->compte->nom}.");
    }
}
