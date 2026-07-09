<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function index()
    {
        $centres = Centre::withCount('formations')->orderBy('nom')->get();
        return view('centres.index', compact('centres'));
    }

    public function create()
    {
        return view('centres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string',
        ]);

        Centre::create($request->all());

        return redirect()->route('centres.index')->with('success', 'Centre de formation créé avec succès.');
    }

    public function destroy(Centre $centre)
    {
        // On empêche la suppression si des formations y sont liées
        if ($centre->formations()->count() > 0) {
            return back()->withErrors(['erreur' => 'Impossible de supprimer ce centre car des formations y sont associées.']);
        }
        
        $centre->delete();
        return redirect()->route('centres.index')->with('success', 'Centre supprimé avec succès.');
    }
}
