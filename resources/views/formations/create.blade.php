@extends('layouts.app')
@section('title', 'Créer une formation — FormationPro')

@section('content')
<div class="mb-4">
    <a href="{{ route('formations.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">← Retour au catalogue</a>
</div>

<div class="flex" style="justify-content: center;">
    <div class="glass-panel" style="max-width: 600px; width: 100%;">
        <div class="text-center mb-6">
            <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#a855f7);font-size:1.5rem;margin-bottom:1rem;">📋</div>
            <h1 style="font-size: 1.75rem;" class="gradient-title">Créer une formation</h1>
            <p class="text-muted text-sm">Renseignez les informations de votre nouvelle session.</p>
        </div>

        <form action="{{ route('formations.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="titre" class="form-label">📌 Titre de la formation</label>
                <input type="text" id="titre" name="titre" required class="form-input {{ $errors->has('titre') ? 'input-error' : '' }}" placeholder="Ex : Laravel Avancé" value="{{ old('titre') }}">
                @error('titre')<p style="color:#fca5a5;font-size:0.8rem;margin-top:0.35rem;">⚠️ {{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">📝 Description</label>
                <textarea id="description" name="description" required rows="4" class="form-input {{ $errors->has('description') ? 'input-error' : '' }}" placeholder="Décrivez le contenu et les objectifs...">{{ old('description') }}</textarea>
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

            <button type="submit" class="btn btn-primary w-full mt-4" style="padding:0.85rem;font-size:1rem;border-radius:14px;">
                🚀 Créer la formation
            </button>
        </form>
    </div>
</div>
@endsection
