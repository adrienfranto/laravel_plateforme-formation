<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Inscription;
use App\Services\CertificatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with('centre', 'formateur')->get();
        return view('formations.index', compact('formations'));
    }

    public function show(Formation $formation)
    {
        $user = Auth::user();
        
        // Si l'utilisateur est le formateur de cette formation
        if ($formation->formateur_id === $user->id) {
            $inscriptions = Inscription::with('compte')->where('formation_id', $formation->id)->get();
            return view('formations.formateur.show', compact('formation', 'inscriptions'));
        }

        // Sinon, c'est un apprenant (on vérifie s'il est inscrit)
        $inscription = Inscription::where('compte_id', $user->id)->where('formation_id', $formation->id)->first();
        return view('formations.apprenant.show', compact('formation', 'inscription'));
    }

    public function cloturer(Formation $formation, CertificatService $certificatService)
    {
        // Seul le formateur peut clôturer
        if ($formation->formateur_id !== Auth::id()) {
            abort(403);
        }

        // Récupérer tous les apprenants inscrits
        $inscriptions = Inscription::where('formation_id', $formation->id)->get();

        foreach ($inscriptions as $inscription) {
            if ($inscription->statut !== 'cloture') {
                $inscription->update(['statut' => 'cloture']);
                $certificatService->genererCertificat($inscription);
            }
        }

        return back()->with('success', 'Formation clôturée et certificats générés.');
    }
}
