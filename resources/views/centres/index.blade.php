@extends('layouts.app')
@section('title', 'Centres de Formation — FormationPro')

@section('content')

{{-- ========================= MODAL NOUVEAU CENTRE ========================= --}}
<div x-data="{ open: false }" @keydown.escape.window="open = false">

    {{-- PAGE HERO --}}
    <div class="page-hero">
        <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 class="gradient-title">Centres de Formation</h1>
                <p>Gérez les centres partenaires où se déroulent les formations.</p>
            </div>
            <button @click="open = true" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                ➕ Nouveau Centre
            </button>
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
        style="position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem; overflow-y: auto;"
    >
        {{-- Backdrop --}}
        <div @click="open = false" style="position: absolute; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(6px);"></div>

        {{-- Contenu --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            style="position: relative; max-width: 500px; width: 100%; background: #0c1525; border: 1px solid rgba(255,255,255,0.12); border-radius: 22px; padding: 2.5rem; box-shadow: 0 30px 80px rgba(0,0,0,0.7); margin: auto;"
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
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, rgba(59,130,246,0.25), rgba(168,85,247,0.25)); border: 2px solid rgba(59,130,246,0.4); font-size: 1.6rem; margin-bottom: 1rem;">🏢</div>
                <h2 style="font-size: 1.4rem; margin-bottom: 0.25rem;">Nouveau Centre</h2>
                <p class="text-muted text-sm">Ajouter un nouveau lieu de formation.</p>
            </div>

            {{-- Formulaire --}}
            <form action="{{ route('centres.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nom" class="form-label">📌 Nom du centre</label>
                    <input type="text" id="nom" name="nom" required class="form-input {{ $errors->has('nom') ? 'input-error' : '' }}" placeholder="Ex : Centre Paris 11" value="{{ old('nom') }}">
                    @error('nom')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="ville" class="form-label">📍 Ville</label>
                    <input type="text" id="ville" name="ville" required class="form-input {{ $errors->has('ville') ? 'input-error' : '' }}" placeholder="Ex : Paris" value="{{ old('ville') }}">
                    @error('ville')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
                </div>

                {{-- Actions --}}
                <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                    <button type="button" @click="open = false" class="btn btn-ghost" style="flex: 1; justify-content: center;">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 0.85rem;">
                        🚀 Créer le centre
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Si erreurs de validation, rouvrir le modal automatiquement --}}
    @if($errors->any() && !$errors->has('erreur'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('open-create-modal'));
        });
    </script>
    @endif

</div>

<div class="glass-panel">
    @if($centres->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--surface-border);">
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Nom du centre</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Ville</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Formations liées</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($centres as $centre)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem; font-weight: 600;">{{ $centre->nom }}</td>
                            <td style="padding: 1rem;">
                                <span class="badge badge-primary">📍 {{ $centre->ville }}</span>
                            </td>
                            <td style="padding: 1rem;">
                                <span class="stat-pill" style="font-size: 0.75rem;">{{ $centre->formations_count }} formation(s)</span>
                            </td>
                            <td style="padding: 1rem; text-align: right;">
                                <form action="{{ route('centres.destroy', $centre) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce centre ?');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.75rem; font-size: 0.8rem;" {{ $centre->formations_count > 0 ? 'disabled' : '' }} title="{{ $centre->formations_count > 0 ? 'Impossible de supprimer un centre lié à des formations' : 'Supprimer' }}">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center" style="padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🏢</div>
            <h2>Aucun centre disponible</h2>
            <p class="text-muted">Créez le premier centre pour commencer à proposer des formations.</p>
        </div>
    @endif
</div>

@if($errors->any() && !$errors->has('erreur'))
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.querySelector('[\\@click="open = true"]');
        if (btn) btn.click();
    });
</script>
@endpush
@endif
@endsection
