<?php
namespace App\Http\Controllers;
use App\Models\Formation;
use App\Models\Inscription;
use App\Services\ParrainageService;
use App\Http\Requests\StoreInscriptionRequest;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller {
    public function store(StoreInscriptionRequest $request, Formation $formation, ParrainageService $parrainageService) {
        $user = Auth::user();
        $inscription = Inscription::firstOrCreate([
            'compte_id' => $user->id,
            'formation_id' => $formation->id,
        ]);
        $parrainageService->gererRecompense($inscription);
        return back()->with('success', 'Vous êtes maintenant inscrit à cette formation.');
    }
}
