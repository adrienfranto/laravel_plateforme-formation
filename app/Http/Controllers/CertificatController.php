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
        
        // Récupérer les certificats de l'utilisateur connecté
        $certificats = Certificat::whereHas('inscription', function ($query) use ($user) {
            $query->where('compte_id', $user->id);
        })->with('inscription.formation')->latest()->get();

        return view('certificats.index', compact('certificats'));
    }
}
