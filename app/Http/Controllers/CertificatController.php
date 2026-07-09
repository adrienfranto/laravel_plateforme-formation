<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Certificat;

class CertificatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Certificats obtenus
        $certificats = Certificat::whereHas('inscription', function ($query) use ($user) {
            $query->where('compte_id', $user->id);
        })->with('inscription.formation.centre')->latest()->get();

        // Historique de toutes les inscriptions
        $inscriptions = \App\Models\Inscription::where('compte_id', $user->id)
            ->with(['formation.centre', 'formation.formateur', 'certificat'])
            ->latest()
            ->get();

        return view('certificats.index', compact('certificats', 'inscriptions'));
    }
}
