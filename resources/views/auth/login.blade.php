@extends('layouts.app')

@section('content')
<div class="flex" style="justify-content: center; align-items: center; min-height: 60vh;">
    <div class="glass-panel" style="max-width: 500px; width: 100%; text-align: center;">
        <h1 class="brand" style="font-size: 2rem; margin-bottom: 0.5rem;">Connexion Rapide (Démo)</h1>
        <p class="text-muted mb-4">Sélectionnez un profil pour tester la plateforme.</p>
        
        <div class="grid grid-cols-1" style="gap: 1rem; margin-top: 2rem;">
            <a href="{{ url('/login/apprenant') }}" class="btn btn-primary" style="padding: 1rem; display: flex; flex-direction: column; align-items: center;">
                <span style="font-size: 1.25rem; margin-bottom: 0.25rem;">🎓</span>
                <strong>Connexion Apprenant</strong>
                <span class="text-muted" style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Se connecter en tant que Alice</span>
            </a>
            
            <a href="{{ url('/login/formateur') }}" class="btn btn-success" style="padding: 1rem; display: flex; flex-direction: column; align-items: center;">
                <span style="font-size: 1.25rem; margin-bottom: 0.25rem;">👨‍🏫</span>
                <strong>Connexion Formateur</strong>
                <span class="text-muted" style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">Se connecter en tant que Jean</span>
            </a>
        </div>
    </div>
</div>
@endsection