@extends('layouts.app')

@section('content')
<div class="flex" style="justify-content: center; align-items: center; min-height: 70vh;">
    <div class="glass-panel" style="max-width: 480px; width: 100%; text-align: center;">
        {{-- Logo / Brand --}}
        <div style="margin-bottom: 2rem;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #c084fc); margin-bottom: 1rem; font-size: 1.8rem;">🎓</div>
            <h1 class="brand" style="font-size: 2rem; margin-bottom: 0.25rem;">FormationPro</h1>
            <p class="text-muted">Connexion rapide (Démo)</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ url('/login/apprenant') }}" class="btn btn-primary" style="padding: 1rem 1.5rem; border-radius: 14px; display: flex; align-items: center; gap: 1rem; text-align: left;">
                <span style="font-size: 2rem; line-height: 1;">🎓</span>
                <div>
                    <div style="font-weight: 700; font-size: 1rem;">Connexion Apprenant</div>
                    <div style="font-size: 0.8rem; opacity: 0.75; font-weight: 400;">Continuer en tant que Alice Apprenante</div>
                </div>
            </a>

            <a href="{{ url('/login/formateur') }}" class="btn btn-success" style="padding: 1rem 1.5rem; border-radius: 14px; display: flex; align-items: center; gap: 1rem; text-align: left;">
                <span style="font-size: 2rem; line-height: 1;">👨‍🏫</span>
                <div>
                    <div style="font-weight: 700; font-size: 1rem;">Connexion Formateur</div>
                    <div style="font-size: 0.8rem; opacity: 0.75; font-weight: 400;">Continuer en tant que Jean Formateur</div>
                </div>
            </a>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--surface-border);">
            <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 0.75rem;">Pas encore de compte ?</p>
            <a href="{{ route('register') }}" class="btn" style="background: rgba(255,255,255,0.08); border: 1px solid var(--surface-border); color: #fff; width: 100%; justify-content: center;">
                ✨ Créer un nouveau compte
            </a>
        </div>
    </div>
</div>
@endsection