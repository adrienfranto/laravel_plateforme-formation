@extends('layouts.app')
@section('title', 'Catalogue des Formations — FormationPro')

@section('content')

{{-- ========================= MODAL CRÉER FORMATION ========================= --}}
@auth
@if(Auth::user()->roles->contains('code', 'formateur'))
<div x-data="{ open: false }" @keydown.escape.window="open = false">

    {{-- PAGE HERO --}}
    <div class="page-hero">
        <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 class="gradient-title">Catalogue des Formations</h1>
                <p>Découvrez nos formations certifiantes et développez vos compétences.</p>
            </div>
            <button @click="open = true" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                ➕ Nouvelle Formation
            </button>
        </div>
        <div class="flex items-center gap-2" style="margin-top: 1rem; flex-wrap: wrap;">
            <span class="stat-pill">📚 {{ $formations->count() }} formation(s)</span>
            <span class="stat-pill">👋 {{ Auth::user()->prenom }} · {{ Auth::user()->roles->first()?->libelle ?? 'Invité' }}</span>
        </div>
    </div>

    {{-- ========================= OVERLAY MODAL ========================= --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="position: fixed; inset: 0; z-index: 9999; display: flex; align-items: flex-start; justify-content: center; padding: 2rem 1rem; overflow-y: auto;"
    >
        {{-- Backdrop --}}
        <div @click="open = false" style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px);"></div>

        {{-- Contenu --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            style="position: relative; max-width: 760px; width: 100%; background: #0c1525; border: 1px solid rgba(255,255,255,0.12); border-radius: 22px; padding: 2.5rem; box-shadow: 0 30px 80px rgba(0,0,0,0.7); margin: auto;"
        >
            {{-- Bouton fermer --}}
            <button
                @click="open = false"
                style="position: absolute; top: 1.25rem; right: 1.25rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); border-radius: 50%; width: 34px; height: 34px; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                @mouseenter="$el.style.background='rgba(255,255,255,0.14)'; $el.style.color='#fff'"
                @mouseleave="$el.style.background='rgba(255,255,255,0.06)'; $el.style.color='var(--text-muted)'"
            >✕</button>

            {{-- Header modal --}}
            <div class="text-center" style="margin-bottom: 2rem;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, rgba(59,130,246,0.25), rgba(168,85,247,0.25)); border: 2px solid rgba(59,130,246,0.4); font-size: 1.6rem; margin-bottom: 1rem;">📋</div>
                <h2 style="font-size: 1.4rem; margin-bottom: 0.25rem;">Créer une formation</h2>
                <p class="text-muted text-sm">Renseignez les informations de votre nouvelle session.</p>
            </div>

            {{-- Formulaire --}}
            <form action="{{ route('formations.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="titre" class="form-label">📌 Titre</label>
                    <input type="text" id="titre" name="titre" required class="form-input {{ $errors->has('titre') ? 'input-error' : '' }}" placeholder="Ex : Laravel Avancé" value="{{ old('titre') }}">
                    @error('titre')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">📝 Description</label>
                    <textarea id="description" name="description" required rows="3" class="form-input {{ $errors->has('description') ? 'input-error' : '' }}" placeholder="Décrivez le contenu et les objectifs...">{{ old('description') }}</textarea>
                    @error('description')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2">
                    <div class="form-group">
                        <label for="date_debut" class="form-label">📅 Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" required class="form-input {{ $errors->has('date_debut') ? 'input-error' : '' }}" value="{{ old('date_debut') }}">
                        @error('date_debut')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="date_fin" class="form-label">📅 Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" required class="form-input {{ $errors->has('date_fin') ? 'input-error' : '' }}" value="{{ old('date_fin') }}">
                        @error('date_fin')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="centre_id" class="form-label">🏢 Centre de formation</label>
                    <select id="centre_id" name="centre_id" required class="form-select {{ $errors->has('centre_id') ? 'input-error' : '' }}">
                        <option value="">— Sélectionnez un centre —</option>
                        @foreach($centres as $centre)
                            <option value="{{ $centre->id }}" {{ old('centre_id') == $centre->id ? 'selected' : '' }}>
                                {{ $centre->nom }} — {{ $centre->ville }}
                            </option>
                        @endforeach
                    </select>
                    @error('centre_id')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                </div>

                {{-- Actions --}}
                <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                    <button type="button" @click="open = false" class="btn btn-ghost" style="flex: 1; justify-content: center;">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 0.85rem;">
                        🚀 Créer la formation
                    </button>
                </div>
            </form>
        </div>
    </div>

{{-- Si erreurs de validation, rouvrir le modal automatiquement --}}
@if($errors->any())
<script>
    document.addEventListener('alpine:init', () => {
        // Le composant Alpine va s'initialiser avec open=true si erreurs
    });
    document.addEventListener('DOMContentLoaded', () => {
        window.dispatchEvent(new CustomEvent('open-create-modal'));
    });
</script>
@endif

@else
    {{-- PAGE HERO pour non-formateurs --}}
    <div class="page-hero">
        <div>
            <h1 class="gradient-title">Catalogue des Formations</h1>
            <p>Découvrez nos formations certifiantes et développez vos compétences.</p>
        </div>
        <div class="flex items-center gap-2" style="margin-top: 1rem; flex-wrap: wrap;">
            <span class="stat-pill">📚 {{ $formations->count() }} formation(s)</span>
            <span class="stat-pill">👋 {{ Auth::user()->prenom }} · {{ Auth::user()->roles->first()?->libelle ?? 'Invité' }}</span>
        </div>
    </div>
@endif
@else
    {{-- PAGE HERO pour non connectés --}}
    <div class="page-hero">
        <h1 class="gradient-title">Catalogue des Formations</h1>
        <p>Découvrez nos formations certifiantes et développez vos compétences.</p>
        <div class="flex items-center gap-2" style="margin-top: 1rem;">
            <span class="stat-pill">📚 {{ $formations->count() }} formation(s)</span>
        </div>
    </div>
@endauth

{{-- BARRE DE RECHERCHE & FILTRE --}}
<form method="GET" action="{{ route('formations.index') }}" class="glass-panel" style="padding: 1.25rem 1.5rem; margin-bottom: 2rem;">
    <div class="grid grid-cols-2" style="gap: 0.75rem; align-items: flex-end;">
        <div>
            <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.35rem;">🔍 Rechercher</label>
            <input type="text" name="search" class="form-input" placeholder="Titre ou description..." value="{{ request('search') }}" style="padding: 0.6rem 0.9rem; font-size: 0.9rem;">
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
            <div class="flex justify-between items-center mb-4">
                <span class="badge badge-primary">🏢 {{ $formation->centre->nom }}</span>
                <span class="stat-pill" style="font-size: 0.72rem; padding: 0.2rem 0.6rem;">
                    👥 {{ $formation->inscriptions->count() }} inscrit(s)
                </span>
            </div>
            <h3 style="font-size: 1.05rem; margin-bottom: 0.6rem; line-height: 1.4;">{{ $formation->titre }}</h3>
            <p style="font-size: 0.88rem; margin-bottom: 1.25rem; min-height: 2.8rem; line-height: 1.5;">{{ Str::limit($formation->description, 100) }}</p>
            <div class="flex items-center gap-2 mb-3" style="font-size: 0.8rem; color: var(--text-muted);">
                <span>📅</span>
                <span>{{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}</span>
                <span style="opacity: 0.5;">→</span>
                <span>{{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}</span>
            </div>
            <div class="flex items-center gap-2 mb-5" style="font-size: 0.82rem; color: var(--text-muted);">
                <div class="user-avatar" style="width: 22px; height: 22px; font-size: 0.6rem;">{{ strtoupper(substr($formation->formateur->prenom, 0, 1)) }}</div>
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
        <h2 style="margin-bottom: 0.5rem;">Aucune formation trouvée</h2>
        <p class="text-muted">
            @if(request('search') || request('centre_id'))
                Aucun résultat pour vos critères.
                <a href="{{ route('formations.index') }}" style="color: var(--primary);">Voir toutes les formations</a>
            @else
                Il n'y a actuellement aucune formation dans le catalogue.
            @endif
        </p>
    </div>
@endif

@endsection

@if($errors->any())
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.querySelector('[\\@click="open = true"]');
        if (btn) btn.click();
    });
</script>
@endpush
@endif