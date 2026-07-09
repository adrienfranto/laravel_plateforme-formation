<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Centre;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isFormateur = $user->roles->contains('code', 'formateur');

        $stats = [];
        $formations = collect();

        if ($isFormateur) {
            $stats['formations_animees'] = Formation::where('formateur_id', $user->id)->count();
            $stats['apprenants_total'] = Inscription::whereHas('formation', function($q) use ($user) {
                $q->where('formateur_id', $user->id);
            })->count();
            $stats['certificats_delivres'] = Inscription::whereHas('formation', function($q) use ($user) {
                $q->where('formateur_id', $user->id);
            })->where('statut', 'cloture')->count();
            
            $formations = Formation::where('formateur_id', $user->id)->latest()->take(5)->get();
        } else {
            $stats['formations_inscrites'] = Inscription::where('compte_id', $user->id)->count();
            $stats['certificats_obtenus'] = Inscription::where('compte_id', $user->id)->where('statut', 'cloture')->count();
            
            $formations = Inscription::with('formation.centre')->where('compte_id', $user->id)->latest()->take(5)->get();
        }

        // Global stats for admin-like view if we want later, but right now just standard dashboard
        $globalStats = [
            'total_centres' => Centre::count(),
            'total_utilisateurs' => Compte::count(),
            'total_formations' => Formation::count(),
        ];

        return view('dashboard', compact('user', 'isFormateur', 'stats', 'formations', 'globalStats'));
    }
}
