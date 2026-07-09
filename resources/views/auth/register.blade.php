@extends('layouts.app')
@section('title', 'Inscription — FormationPro')

@section('content')
<div class="flex" style="justify-content: center; align-items: flex-start; min-height: 70vh; padding-top: 2rem;">
    <div class="glass-panel" style="max-width: 520px; width: 100%;">

        {{-- Header de la carte --}}
        <div class="text-center mb-6">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #a855f7); font-size: 1.5rem; margin-bottom: 1rem;">✨</div>
            <h1 style="font-size: 1.75rem; margin-bottom: 0.25rem;" class="gradient-title">Créer un compte</h1>
            <p class="text-muted text-sm">Rejoignez la plateforme et démarrez votre parcours.</p>
        </div>

        <form action="{{ url('/comptes') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required class="form-input" placeholder="Alice" value="{{ old('prenom') }}">
                </div>
                <div class="form-group">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" id="nom" name="nom" required class="form-input" placeholder="Dupont" value="{{ old('nom') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="telephone" class="form-label">📱 Téléphone</label>
                <input type="text" id="telephone" name="telephone" required class="form-input" placeholder="0600000000" value="{{ old('telephone') }}">
            </div>

            <div class="form-group" x-data="{ show: false }">
                <label for="password" class="form-label">🔒 Mot de passe</label>
                <div style="position: relative;">
                    <input
                        :type="show ? 'text' : 'password'"
                        id="password"
                        name="password"
                        required
                        class="form-input"
                        placeholder="Min. 6 caractères"
                        style="padding-right: 3rem;"
                    >
                    <button
                        type="button"
                        @click="show = !show"
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 1.1rem; line-height: 1; transition: color 0.2s;"
                        :title="show ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                        @mouseenter="$el.style.color = 'var(--text-main)'"
                        @mouseleave="$el.style.color = 'var(--text-muted)'"
                    >
                        <span x-show="!show">👁️</span>
                        <span x-show="show">🙈</span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="role_id" class="form-label">🎭 Je suis un...</label>
                <select id="role_id" name="role_id" required class="form-select">
                    <option value="">— Sélectionnez votre rôle —</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-full mt-4" style="padding: 0.85rem; font-size: 1rem; border-radius: 14px;">
                🚀 Créer mon compte
            </button>
        </form>

        <hr class="divider">

        <div class="text-center">
            <p class="text-muted text-sm mb-2">Déjà un compte ?</p>
            <a href="{{ route('login') }}" class="btn btn-ghost" style="width: 100%; justify-content: center;">Se connecter</a>
        </div>
    </div>
</div>
@endsection
