@extends('layouts.app')
@section('title', 'Nouveau Centre — FormationPro')

@section('content')
<div class="mb-4">
    <a href="{{ route('centres.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">← Retour aux centres</a>
</div>

<div class="flex" style="justify-content: center;">
    <div class="glass-panel" style="max-width: 500px; width: 100%;">
        <div class="text-center mb-6">
            <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#a855f7);font-size:1.5rem;margin-bottom:1rem;">🏢</div>
            <h1 style="font-size: 1.75rem;" class="gradient-title">Nouveau Centre</h1>
            <p class="text-muted text-sm">Ajouter un nouveau lieu de formation.</p>
        </div>

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

            <div class="form-group">
                <label for="adresse" class="form-label">🏠 Adresse complète</label>
                <textarea id="adresse" name="adresse" required rows="3" class="form-input {{ $errors->has('adresse') ? 'input-error' : '' }}" placeholder="Ex : 15 rue de la Paix, 75000 Paris">{{ old('adresse') }}</textarea>
                @error('adresse')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn-primary w-full mt-4" style="padding:0.85rem;font-size:1rem;border-radius:14px;">
                🚀 Créer le centre
            </button>
        </form>
    </div>
</div>
@endsection
