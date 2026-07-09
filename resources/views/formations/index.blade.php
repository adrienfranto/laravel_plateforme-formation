@extends('layouts.app')
@section('title', 'Catalogue des Formations — FormationPro')

@section('content')
<div class="page-hero">
    <h1 class="gradient-title">Catalogue des Formations</h1>
    <p>Découvrez nos formations certifiantes et développez vos compétences.</p>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 1rem;">
        <span class="stat-pill">📚 {{ $formations->count() }} formations disponibles</span>
        @auth
            <span class="stat-pill">👋 Bonjour, {{ Auth::user()->prenom }} !</span>
        @endauth
    </div>
</div>

@if($formations->count() > 0)
    <div class="grid grid-cols-2">
        @foreach($formations as $formation)
        <div class="card-formation">
            {{-- Centre badge --}}
            <div class="flex justify-between items-center mb-4">
                <span class="badge badge-primary">🏢 {{ $formation->centre->nom }}</span>
                <span class="badge" style="font-size: 0.7rem; color: var(--text-muted);">
                    {{ $formation->inscriptions->count() }} inscrit(s)
                </span>
            </div>

            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">{{ $formation->titre }}</h3>
            <p style="font-size: 0.9rem; margin-bottom: 1.25rem; min-height: 3rem;">{{ Str::limit($formation->description, 110) }}</p>

            {{-- Dates --}}
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem; font-size: 0.8rem; color: var(--text-muted);">
                <span>📅</span>
                <span>{{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}</span>
                <span>→</span>
                <span>{{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}</span>
            </div>

            {{-- Formateur --}}
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
                <div class="user-avatar" style="width: 22px; height: 22px; font-size: 0.65rem;">{{ strtoupper(substr($formation->formateur->prenom, 0, 1)) }}</div>
                <span>{{ $formation->formateur->prenom }} {{ $formation->formateur->nom }}</span>
            </div>

            <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-primary w-full" style="justify-content: center;">
                Voir les détails →
            </a>
        </div>
        @endforeach
    </div>
@else
    <div class="glass-panel text-center" style="padding: 4rem 2rem;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
        <h2>Aucune formation disponible</h2>
        <p>Il n'y a actuellement aucune formation dans le catalogue.</p>
    </div>
@endif
@endsection