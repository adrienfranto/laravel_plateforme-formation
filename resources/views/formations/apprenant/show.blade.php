@extends('layouts.app')
@section('title', $formation->titre . ' — FormationPro')

@section('content')
<div class="mb-4">
    <a href="{{ route('formations.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">← Retour au catalogue</a>
</div>

<div class="glass-panel" style="margin-bottom: 1.5rem;">
    <div class="flex justify-between items-center mb-4" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <span class="badge badge-primary mb-2">🏢 {{ $formation->centre->nom }}</span>
            <h1 style="font-size: 1.75rem;">{{ $formation->titre }}</h1>
        </div>
        <div style="text-align: right;">
            <div class="stat-pill mb-2">
                📅 Du {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}
            </div>
        </div>
    </div>
    <p>{{ $formation->description }}</p>

    <div class="flex items-center gap-2 mt-4">
        <div class="user-avatar">{{ strtoupper(substr($formation->formateur->prenom, 0, 1)) }}</div>
        <span class="text-muted text-sm">Formé par <strong style="color: var(--text-main);">{{ $formation->formateur->prenom }} {{ $formation->formateur->nom }}</strong></span>
    </div>
</div>

<hr class="divider">

@if(!$inscription)
    <div class="glass-panel" x-data="{ confirming: false }">
        <div x-show="!confirming">
            <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Rejoindre cette formation</h2>
            <p>Inscrivez-vous dès maintenant pour accéder à ce parcours certifiant.</p>
            <button @click="confirming = true" class="btn btn-primary mt-4">
                🚀 M'inscrire à cette formation
            </button>
        </div>

        <div x-show="confirming" x-transition style="border: 1px solid rgba(59,130,246,0.3); border-radius: var(--radius-md); padding: 1.5rem; background: rgba(59,130,246,0.07);">
            <h3 style="margin-bottom: 0.5rem;">Confirmer l'inscription ?</h3>
            <p>Vous êtes sur le point de vous inscrire à <strong>{{ $formation->titre }}</strong>. Cette action est irréversible.</p>
            <div class="flex gap-4 mt-4">
                <form action="{{ url('/formations/'.$formation->id.'/inscriptions') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">✅ Confirmer</button>
                </form>
                <button @click="confirming = false" class="btn btn-ghost">Annuler</button>
            </div>
        </div>
    </div>
@else
    <div class="glass-panel" style="background: rgba(16, 185, 129, 0.08); border-color: rgba(16, 185, 129, 0.25);">
        <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="color: #6ee7b7; font-size: 1.15rem; margin-bottom: 0.25rem;">✅ Vous êtes inscrit(e)</h2>
                <p style="margin: 0;">Statut actuel :
                    <span class="badge {{ $inscription->statut === 'cloture' ? 'badge-danger' : 'badge-success' }}">
                        {{ ucfirst($inscription->statut) }}
                    </span>
                </p>
            </div>
            @if($inscription->statut === 'cloture' && $inscription->certificat)
                <a href="{{ url('/verify/'.$inscription->certificat->uuid_public) }}" class="btn btn-primary">
                    🎓 Voir mon certificat
                </a>
            @endif
        </div>
    </div>
@endif
@endsection