<?php

namespace App\Services;

use App\Models\Parrainage;
use App\Models\Inscription;

class ParrainageService
{
    public function gererRecompense(Inscription $inscription)
    {
        // On vérifie si l'apprenant (filleul) a un parrain pour ce centre
        $parrainage = Parrainage::where('filleul_id', $inscription->compte_id)
            ->where('centre_id', $inscription->formation->centre_id)
            ->where('recompense_declenchee', false)
            ->first();

        if ($parrainage) {
            // Vérifier si c'est bien la 1ère inscription du filleul dans ce centre
            $inscriptionsCount = Inscription::where('compte_id', $inscription->compte_id)
                ->whereHas('formation', function ($query) use ($inscription) {
                    $query->where('centre_id', $inscription->formation->centre_id);
                })
                ->count();

            // S'il n'y a qu'une inscription, c'est celle qui vient d'être faite
            if ($inscriptionsCount === 1) {
                // Déclencher la récompense
                $parrainage->update(['recompense_declenchee' => true]);
                // (Logique d'attribution de la récompense au parrain ici)
            }
        }
    }
}