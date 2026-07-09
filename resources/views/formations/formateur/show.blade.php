@extends('layouts.app')
@section('title', 'Espace Formateur — ' . $formation->titre)

@section('content')
<div class="mb-4">
    <a href="{{ route('formations.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">← Retour au catalogue</a>
</div>

{{-- Header formation --}}
<div class="glass-panel" style="margin-bottom: 1.5rem;">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <div>
            <span class="badge badge-purple mb-2">👨‍🏫 Espace Formateur</span>
            <h1 style="font-size: 1.75rem;">{{ $formation->titre }}</h1>
            @if(!$isOwner)
                <p class="text-muted text-sm" style="margin-top: 0.4rem;">Formateur : {{ $formation->formateur->prenom }} {{ $formation->formateur->nom }}</p>
            @endif
        </div>
        <div class="flex gap-2" style="flex-wrap: wrap;">
            <span class="stat-pill">🏢 {{ $formation->centre->nom }}</span>
            <span class="stat-pill">📅 {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}</span>
        </div>
    </div>
    <p>{{ $formation->description }}</p>
</div>

{{-- Panel inscrits --}}
<div class="glass-panel">
    <div class="flex justify-between items-center mb-6" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin-bottom: 0.25rem;">Apprenants inscrits</h2>
            <p style="margin: 0;" class="text-sm">
                <span class="badge badge-primary">{{ $inscriptions->count() }} inscrit(s)</span>
            </p>
        </div>

        @if($isOwner)
            @if($inscriptions->count() > 0 && !$inscriptions->where('statut', 'cloture')->count())
                <form action="{{ url('/formations/'.$formation->id.'/cloturer') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-success"
                        onclick="return confirm('Clôturer la formation et générer les certificats pour tous les apprenants ?')"
                    >
                        🎓 Clôturer et délivrer les certificats
                    </button>
                </form>
            @elseif($inscriptions->where('statut', 'cloture')->count())
                <span class="badge badge-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Formation clôturée</span>
            @endif
        @else
            @if($inscriptions->where('statut', 'cloture')->count())
                <span class="badge badge-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Formation clôturée</span>
            @else
                <span class="badge" style="background: rgba(255,255,255,0.1); color: var(--text-muted); padding: 0.5rem 1rem; font-size: 0.85rem;">👁️ Lecture seule</span>
            @endif
        @endif
    </div>

    @if($inscriptions->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($inscriptions as $inscription)
            <div style="background: rgba(255,255,255,0.04); border: 1px solid var(--surface-border); border-radius: var(--radius-md); overflow: hidden;">
                {{-- Ligne principale --}}
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                    <div class="flex items-center gap-4">
                        <div class="user-avatar" style="width: 38px; height: 38px; font-size: 0.9rem;">
                            {{ strtoupper(substr($inscription->compte->prenom, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600;">{{ $inscription->compte->prenom }} {{ $inscription->compte->nom }}</div>
                            <div class="text-muted text-sm">{{ $inscription->compte->telephone }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($inscription->note !== null)
                            <span style="font-weight: 700; font-size: 1.1rem; color: {{ $inscription->note >= 10 ? '#4ade80' : '#f87171' }};">
                                {{ number_format($inscription->note, 2) }}/20
                            </span>
                        @endif
                        <span class="badge {{ $inscription->statut === 'cloture' ? 'badge-danger' : 'badge-success' }}">
                            {{ ucfirst($inscription->statut) }}
                        </span>
                        @if($inscription->statut === 'cloture' && $inscription->certificat)
                            <div class="flex gap-1 ml-2">
                                <a href="{{ url('/verify/'.$inscription->certificat->uuid_public) }}" class="btn btn-ghost" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" title="Voir le certificat public">
                                    📄
                                </a>
                                <a href="{{ route('certificats.show', $inscription->certificat) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" title="Télécharger le certificat PDF">
                                    📥 PDF
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Formulaire de note (owner seulement) --}}
                @if($isOwner)
                <div style="border-top: 1px solid rgba(255,255,255,0.05); padding: 0.85rem 1.25rem; background: rgba(0,0,0,0.15);" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        type="button"
                        style="background: none; border: none; color: var(--text-muted); cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem; padding: 0;"
                    >
                        <span x-text="open ? '▲ Masquer' : '✏️ Attribuer / modifier la note'"></span>
                    </button>
                    <div x-show="open" x-transition style="margin-top: 0.85rem;">
                        <form action="{{ route('notes.store', $inscription) }}" method="POST" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: flex-end;">
                            @csrf
                            <div style="flex: 0 0 120px;">
                                <label style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-bottom: 0.3rem;">Note /20</label>
                                <input type="number" name="note" step="0.01" min="0" max="20"
                                    class="form-input"
                                    style="padding: 0.5rem 0.75rem; font-size: 0.95rem;"
                                    value="{{ $inscription->note }}"
                                    placeholder="Ex: 16.5" required>
                            </div>
                            <div style="flex: 1; min-width: 200px;">
                                <label style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-bottom: 0.3rem;">Commentaire (optionnel)</label>
                                <input type="text" name="commentaire"
                                    class="form-input"
                                    style="padding: 0.5rem 0.75rem; font-size: 0.9rem;"
                                    value="{{ $inscription->commentaire }}"
                                    placeholder="Ex: Excellent travail sur les projets...">
                            </div>
                            <button type="submit" class="btn btn-primary" style="padding: 0.55rem 1rem; font-size: 0.85rem; white-space: nowrap;">
                                💾 Enregistrer
                            </button>
                        </form>
                    </div>
                </div>
                @elseif($inscription->note !== null)
                <div style="border-top: 1px solid rgba(255,255,255,0.05); padding: 0.65rem 1.25rem; background: rgba(0,0,0,0.1);">
                    @if($inscription->commentaire)
                        <p class="text-muted text-sm" style="margin: 0;">💬 {{ $inscription->commentaire }}</p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center" style="padding: 3rem 0;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">📭</div>
            <p class="text-muted">Aucun apprenant n'est encore inscrit à cette formation.</p>
        </div>
    @endif
</div>
@endsection