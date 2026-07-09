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
        <span class="stat-pill">
            📅 {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}
            → {{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}
        </span>
    </div>
    <p>{{ $formation->description }}</p>

    <div class="flex items-center gap-2 mt-4">
        <div class="user-avatar">{{ strtoupper(substr($formation->formateur->prenom, 0, 1)) }}</div>
        <span class="text-muted text-sm">
            Formé par <strong style="color: var(--text-main);">{{ $formation->formateur->prenom }} {{ $formation->formateur->nom }}</strong>
        </span>
    </div>
</div>

<hr class="divider">

@if(!$inscription)
    {{-- ===================== MODAL D'INSCRIPTION ===================== --}}
    <div x-data="{ open: false }">

        {{-- Bouton déclencheur --}}
        <div class="glass-panel" style="text-align: center; padding: 2.5rem;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🚀</div>
            <h2 style="margin-bottom: 0.5rem;">Rejoindre cette formation</h2>
            <p class="text-muted" style="margin-bottom: 1.5rem;">Inscrivez-vous dès maintenant pour accéder à ce parcours certifiant.</p>
            <button @click="open = true" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 1rem; border-radius: 14px;">
                ✨ M'inscrire à cette formation
            </button>
        </div>

        {{-- ===== OVERLAY MODAL ===== --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="open = false"
            style="position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem;"
        >
            {{-- Backdrop --}}
            <div
                @click="open = false"
                style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px);"
            ></div>

            {{-- Contenu du modal --}}
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                style="position: relative; max-width: 460px; width: 100%; background: #0f1829; border: 1px solid rgba(255,255,255,0.12); border-radius: 20px; padding: 2.5rem; box-shadow: 0 25px 60px rgba(0,0,0,0.6); text-align: center;"
            >
                {{-- Bouton fermer --}}
                <button
                    @click="open = false"
                    style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); border-radius: 50%; width: 32px; height: 32px; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                    @mouseenter="$el.style.background='rgba(255,255,255,0.12)'; $el.style.color='#fff'"
                    @mouseleave="$el.style.background='rgba(255,255,255,0.06)'; $el.style.color='var(--text-muted)'"
                >✕</button>

                {{-- Icône --}}
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(168,85,247,0.2)); border: 2px solid rgba(59,130,246,0.4); font-size: 2rem; margin-bottom: 1.25rem;">
                    🎓
                </div>

                <h2 style="font-size: 1.3rem; margin-bottom: 0.5rem;">Confirmer l'inscription</h2>
                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.25rem;">
                    Vous êtes sur le point de vous inscrire à :
                </p>
                <p style="font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; font-size: 1rem;">
                    "{{ $formation->titre }}"
                </p>

                {{-- Infos recap --}}
                <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 1rem; margin-bottom: 1.75rem; text-align: left;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <span class="text-muted">Centre</span>
                        <span style="font-weight: 600;">{{ $formation->centre->nom }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <span class="text-muted">Début</span>
                        <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                        <span class="text-muted">Fin</span>
                        <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}</span>
                    </div>
                </div>

                <p class="text-muted" style="font-size: 0.78rem; margin-bottom: 1.5rem;">
                    ⚠️ Cette action est irréversible. Vous recevrez un certificat à l'issue de la formation.
                </p>

                {{-- Boutons d'action --}}
                <div style="display: flex; gap: 0.75rem;">
                    <button
                        @click="open = false"
                        class="btn btn-ghost"
                        style="flex: 1; justify-content: center;"
                    >
                        Annuler
                    </button>
                    <form action="{{ url('/formations/'.$formation->id.'/inscriptions') }}" method="POST" style="flex: 2;">
                        @csrf
                        <button type="submit" class="btn btn-primary w-full" style="justify-content: center; padding: 0.75rem;">
                            ✅ Confirmer l'inscription
                        </button>
                    </form>
                </div>
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