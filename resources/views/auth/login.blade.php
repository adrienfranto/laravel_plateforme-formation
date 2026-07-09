@extends('layouts.app')
@section('title', 'Connexion — FormationPro')

@section('content')
<div class="flex" style="justify-content: center; align-items: flex-start; min-height: 75vh; padding-top: 3rem;">
    <div class="glass-panel" style="max-width: 460px; width: 100%;">

        {{-- Brand header --}}
        <div class="text-center mb-6">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #a855f7); font-size: 1.6rem; margin-bottom: 1rem;">🎓</div>
            <h1 class="brand" style="font-size: 2rem; margin-bottom: 0.25rem;">FormationPro</h1>
            <p class="text-muted text-sm">Connectez-vous à votre espace</p>
        </div>

        {{-- Formulaire de connexion --}}
        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="telephone" class="form-label">📱 Téléphone</label>
                <input
                    type="text"
                    id="telephone"
                    name="telephone"
                    required
                    class="form-input {{ $errors->has('telephone') ? 'input-error' : '' }}"
                    placeholder="0600000000"
                    value="{{ old('telephone') }}"
                    autocomplete="username"
                >
                @error('telephone')
                    <p style="color: #fca5a5; font-size: 0.8rem; margin-top: 0.4rem;">⚠️ {{ $message }}</p>
                @enderror
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
                        placeholder="Votre mot de passe"
                        style="padding-right: 3rem;"
                        autocomplete="current-password"
                    >
                    <button
                        type="button"
                        @click="show = !show"
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 1.1rem; transition: color 0.2s;"
                        :title="show ? 'Masquer' : 'Afficher'"
                        @mouseenter="$el.style.color='var(--text-main)'"
                        @mouseleave="$el.style.color='var(--text-muted)'"
                    >
                        <span x-show="!show">👁️</span>
                        <span x-show="show">🙈</span>
                    </button>
                </div>
            </div>

            <div class="flex justify-between items-center mb-6" style="margin-top: -0.25rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.85rem; color: var(--text-muted);">
                    <input type="checkbox" name="remember" style="accent-color: var(--primary);">
                    Se souvenir de moi
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-full" style="padding: 0.85rem; font-size: 1rem; border-radius: 14px;">
                Se connecter →
            </button>
        </form>

        <hr class="divider">

        {{-- Connexions rapides démo --}}
        <div style="margin-bottom: 1.25rem;">
            <p class="text-muted text-sm text-center mb-2">Accès rapide (Démo)</p>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ url('/login/apprenant') }}" class="btn btn-ghost" style="flex: 1; justify-content: center; font-size: 0.85rem;">
                    🎓 Apprenant
                </a>
                <a href="{{ url('/login/formateur') }}" class="btn btn-ghost" style="flex: 1; justify-content: center; font-size: 0.85rem;">
                    👨‍🏫 Formateur
                </a>
            </div>
        </div>

        <div class="text-center">
            <p class="text-muted text-sm" style="margin-bottom: 0;">
                Pas encore de compte ?
                <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                    S'inscrire gratuitement
                </a>
            </p>
        </div>

    </div>
</div>
@endsection