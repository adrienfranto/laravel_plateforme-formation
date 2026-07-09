@extends('layouts.app')
@section('title', 'Catalogue des Formations — FormationPro')

@section('content')

{{-- PAGE HERO --}}
<div class="page-hero">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="gradient-title">Catalogue des Formations</h1>
            <p>Découvrez nos formations certifiantes et développez vos compétences.</p>
        </div>
        @auth
            @if(Auth::user()->roles->contains('code', 'formateur'))
                <a href="{{ route('formations.create') }}" class="btn btn-primary">
                    ➕ Nouvelle Formation
                </a>
            @endif
        @endauth
    </div>

    {{-- Stats + filtres --}}
    <div class="flex items-center gap-2" style="margin-top: 1rem; flex-wrap: wrap;">
        <span class="stat-pill">📚 {{ $formations->count() }} formation(s)</span>
        @auth
            <span class="stat-pill">👋 {{ Auth::user()->prenom }} · {{ Auth::user()->roles->first()?->libelle ?? 'Invité' }}</span>
        @endauth
    </div>
</div>

{{-- BARRE DE RECHERCHE & FILTRE --}}
<form method="GET" action="{{ route('formations.index') }}" class="glass-panel" style="padding: 1.25rem 1.5rem; margin-bottom: 2rem;">
    <div class="grid grid-cols-2" style="gap: 0.75rem; align-items: flex-end;">
        <div>
            <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.35rem;">🔍 Rechercher</label>
            <input
                type="text"
                name="search"
                class="form-input"
                placeholder="Titre ou description..."
                value="{{ request('search') }}"
                style="padding: 0.6rem 0.9rem; font-size: 0.9rem;"
            >
        </div>
        <div>
            <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.35rem;">🏢 Centre</label>
            <select name="centre_id" class="form-select" style="padding: 0.6rem 0.9rem; font-size: 0.9rem;">
                <option value="">Tous les centres</option>
                @foreach($centres as $centre)
                    <option value="{{ $centre->id }}" {{ request('centre_id') == $centre->id ? 'selected' : '' }}>
                        {{ $centre->nom }} — {{ $centre->ville }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.25rem; font-size: 0.9rem;">Filtrer</button>
        @if(request('search') || request('centre_id'))
            <a href="{{ route('formations.index') }}" class="btn btn-ghost" style="padding: 0.6rem 1.25rem; font-size: 0.9rem;">✕ Réinitialiser</a>
        @endif
    </div>
</form>

{{-- GRILLE DES FORMATIONS --}}
@if($formations->count() > 0)
    <div class="grid grid-cols-2">
        @foreach($formations as $formation)
        <div class="card-formation">
            {{-- Top row --}}
            <div class="flex justify-between items-center mb-4">
                <span class="badge badge-primary">🏢 {{ $formation->centre->nom }}</span>
                <span class="stat-pill" style="font-size: 0.72rem; padding: 0.2rem 0.6rem;">
                    👥 {{ $formation->inscriptions->count() }} inscrit(s)
                </span>
            </div>

            {{-- Titre --}}
            <h3 style="font-size: 1.05rem; margin-bottom: 0.6rem; line-height: 1.4;">
                {{ $formation->titre }}
            </h3>

            {{-- Description --}}
            <p style="font-size: 0.88rem; margin-bottom: 1.25rem; min-height: 2.8rem; line-height: 1.5;">
                {{ Str::limit($formation->description, 100) }}
            </p>

            {{-- Dates --}}
            <div class="flex items-center gap-2 mb-3" style="font-size: 0.8rem; color: var(--text-muted);">
                <span>📅</span>
                <span>{{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}</span>
                <span style="opacity: 0.5;">→</span>
                <span>{{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}</span>
            </div>

            {{-- Formateur --}}
            <div class="flex items-center gap-2 mb-5" style="font-size: 0.82rem; color: var(--text-muted);">
                <div class="user-avatar" style="width: 22px; height: 22px; font-size: 0.6rem;">
                    {{ strtoupper(substr($formation->formateur->prenom, 0, 1)) }}
                </div>
                <span>{{ $formation->formateur->prenom }} {{ $formation->formateur->nom }}</span>
            </div>

            {{-- CTA --}}
            <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-primary w-full" style="justify-content: center;">
                Voir les détails →
            </a>
        </div>
        @endforeach
    </div>
@else
    {{-- État vide --}}
    <div class="glass-panel text-center" style="padding: 4rem 2rem;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
        <h2 style="margin-bottom: 0.5rem;">Aucune formation trouvée</h2>
        <p class="text-muted">
            @if(request('search') || request('centre_id'))
                Aucun résultat pour vos critères de recherche.
                <a href="{{ route('formations.index') }}" style="color: var(--primary);">Voir toutes les formations</a>
            @else
                Il n'y a actuellement aucune formation dans le catalogue.
            @endif
        </p>
    </div>
@endif

@endsection