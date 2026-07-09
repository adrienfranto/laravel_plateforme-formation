<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Inscription;
use App\Services\ParrainageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function store(Formation $formation, ParrainageService $parrainageService)
    {
        $user = Auth::user();

        // Vérifier que la formation n'est pas déjà clôturée
        // (on simplifie pour l'exercice)

        $inscription = Inscription::firstOrCreate([
            'compte_id' => $user->id,
            'formation_id' => $formation->id,
        ]);

        // Appel au service métier bonus (parrainage)
        $parrainageService->gererRecompense($inscription);

        return back()->with('success', 'Vous êtes maintenant inscrit à cette formation.');
    }
}
