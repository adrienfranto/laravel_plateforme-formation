@extends('layouts.app')
@section('title', 'Tableau de Bord — FormationPro')

@section('content')
<div class="page-hero">
    <h1 class="gradient-title">Tableau de bord</h1>
    <p>Bienvenue sur votre espace personnel, {{ $user->prenom }}.</p>
</div>

<div class="grid grid-cols-3 mb-6">
    @if($isFormateur)
        <div class="glass-panel text-center" style="padding: 1.5rem;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📚</div>
            <h3 style="font-size: 1.5rem; margin-bottom: 0;">{{ $stats['formations_animees'] }}</h3>
            <p class="text-muted text-sm" style="margin: 0;">Formations animées</p>
        </div>
        <div class="glass-panel text-center" style="padding: 1.5rem;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
            <h3 style="font-size: 1.5rem; margin-bottom: 0;">{{ $stats['apprenants_total'] }}</h3>
            <p class="text-muted text-sm" style="margin: 0;">Apprenants inscrits</p>
        </div>
        <div class="glass-panel text-center" style="padding: 1.5rem;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎓</div>
            <h3 style="font-size: 1.5rem; margin-bottom: 0;">{{ $stats['certificats_delivres'] }}</h3>
            <p class="text-muted text-sm" style="margin: 0;">Certificats délivrés</p>
        </div>
    @else
        <div class="glass-panel text-center" style="padding: 1.5rem;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📖</div>
            <h3 style="font-size: 1.5rem; margin-bottom: 0;">{{ $stats['formations_inscrites'] }}</h3>
            <p class="text-muted text-sm" style="margin: 0;">Formations en cours</p>
        </div>
        <div class="glass-panel text-center" style="padding: 1.5rem;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎓</div>
            <h3 style="font-size: 1.5rem; margin-bottom: 0;">{{ $stats['certificats_obtenus'] }}</h3>
            <p class="text-muted text-sm" style="margin: 0;">Certificats obtenus</p>
        </div>
        <div class="glass-panel text-center" style="padding: 1.5rem; opacity: 0.5;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">⭐</div>
            <h3 style="font-size: 1.5rem; margin-bottom: 0;">-</h3>
            <p class="text-muted text-sm" style="margin: 0;">Prochaine étape</p>
        </div>
    @endif
</div>

<div class="glass-panel mb-6">
    <h2 style="font-size: 1.25rem; margin-bottom: 1rem;">Activité récente</h2>
    
    @if($formations->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($formations as $item)
                @php 
                    $formation = $isFormateur ? $item : $item->formation; 
                    $status = !$isFormateur ? $item->statut : null;
                @endphp
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; background: rgba(255,255,255,0.04); border: 1px solid var(--surface-border); border-radius: var(--radius-md);">
                    <div>
                        <div style="font-weight: 600; margin-bottom: 0.25rem;">
                            <a href="{{ route('formations.show', $formation->id) }}" style="color: var(--text-main); text-decoration: none;">{{ $formation->titre }}</a>
                        </div>
                        <div class="text-muted text-sm">
                            📅 {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }} — 🏢 {{ $formation->centre->nom }}
                        </div>
                    </div>
                    @if(!$isFormateur)
                        <span class="badge {{ $status === 'cloture' ? 'badge-danger' : 'badge-success' }}">
                            {{ ucfirst($status) }}
                        </span>
                    @else
                        <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-ghost" style="padding: 0.4rem 0.75rem; font-size: 0.8rem;">Gérer</a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted" style="text-align: center; padding: 2rem;">Aucune activité récente.</p>
    @endif
</div>

{{-- Global stats (Optionnel) --}}
@if($isFormateur)
<div class="grid grid-cols-3" style="margin-top: 2rem; border-top: 1px solid var(--surface-border); padding-top: 2rem;">
    <div>
        <div style="font-size: 1.2rem; font-weight: 700;">🏢 {{ $globalStats['total_centres'] }}</div>
        <div class="text-muted text-sm">Centres partenaires</div>
    </div>
    <div>
        <div style="font-size: 1.2rem; font-weight: 700;">👥 {{ $globalStats['total_utilisateurs'] }}</div>
        <div class="text-muted text-sm">Utilisateurs inscrits</div>
    </div>
    <div>
        <div style="font-size: 1.2rem; font-weight: 700;">📚 {{ $globalStats['total_formations'] }}</div>
        <div class="text-muted text-sm">Formations au total</div>
    </div>
</div>
@endif

@endsection
