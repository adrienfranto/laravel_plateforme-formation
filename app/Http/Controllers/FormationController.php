<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use App\Models\Formation;
use App\Models\Inscription;
use App\Services\CertificatService;
use App\Http\Requests\StoreFormationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    public function index(Request $request)
    {
        $query = Formation::with('centre', 'formateur', 'inscriptions');

        // Filtre par recherche
        if ($request->filled('search')) {
            $query->where('titre', 'ilike', '%' . $request->search . '%')
                  ->orWhere('description', 'ilike', '%' . $request->search . '%');
        }

        // Filtre par centre
        if ($request->filled('centre_id')) {
            $query->where('centre_id', $request->centre_id);
        }

        $formations = $query->latest()->get();
        $centres    = Centre::orderBy('nom')->get();

        return view('formations.index', compact('formations', 'centres'));
    }

    public function show(Formation $formation)
    {
        $user = Auth::user();
        $isFormateur = $user->roles->contains('code', 'formateur');

        // Tous les formateurs voient la liste des inscrits (pas de bouton inscription)
        if ($isFormateur) {
            $inscriptions = Inscription::with('compte')
                ->where('formation_id', $formation->id)
                ->get();

            // Seul le formateur propriétaire peut clôturer
            $isOwner = $formation->formateur_id === $user->id;

            return view('formations.formateur.show', compact('formation', 'inscriptions', 'isOwner'));
        }

        // Apprenants : bouton inscription + leur statut
        $inscription = Inscription::where('compte_id', $user->id)
            ->where('formation_id', $formation->id)
            ->with('certificat')
            ->first();

        return view('formations.apprenant.show', compact('formation', 'inscription'));
    }

    public function create()
    {
        $centres = Centre::all();
        return view('formations.create', compact('centres'));
    }

    public function store(StoreFormationRequest $request)
    {
        Formation::create([
            'titre'        => $request->titre,
            'description'  => $request->description,
            'date_debut'   => $request->date_debut,
            'date_fin'     => $request->date_fin,
            'centre_id'    => $request->centre_id,
            'formateur_id' => Auth::id(),
        ]);

        return redirect()->route('formations.index')
            ->with('success', 'Formation créée avec succès !');
    }

    public function cloturer(Formation $formation, CertificatService $certificatService)
    {
        if ($formation->formateur_id !== Auth::id()) {
            abort(403);
        }

        $inscriptions = Inscription::where('formation_id', $formation->id)->get();

        foreach ($inscriptions as $inscription) {
            if ($inscription->statut !== 'cloture') {
                $inscription->update(['statut' => 'cloture']);
                $certificatService->genererCertificat($inscription);
            }
        }

        return back()->with('success', 'Formation clôturée et certificats générés pour tous les apprenants.');
    }
}
