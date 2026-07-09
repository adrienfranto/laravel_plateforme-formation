<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat Valide — FormationPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">

<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div style="max-width: 580px; width: 100%; padding: 2rem; position: relative; z-index: 1;">
    <div class="glass-panel" style="border-top: 4px solid var(--success); text-align: center;">
        {{-- Badge valide --}}
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 50%; background: rgba(16,185,129,0.15); border: 2px solid rgba(16,185,129,0.4); font-size: 2.2rem; margin-bottom: 1.25rem;">🎓</div>

        <span class="badge badge-success" style="font-size: 0.8rem; padding: 0.35rem 0.85rem; margin-bottom: 1rem; display: inline-flex;">✅ Certificat Authentique</span>

        <h1 style="color: #6ee7b7; font-size: 1.5rem; margin-bottom: 0.25rem;">Certificat de Formation</h1>
        <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0;">Ce document certifie la réussite officielle du parcours.</p>

        <hr class="divider">

        <h2 style="font-size: 1.25rem; margin-bottom: 0.5rem;">{{ $certificat->inscription->formation->titre }}</h2>

        <p style="font-size: 1rem; margin-bottom: 0.25rem;">
            Décerné à <strong style="color: var(--text-main);">{{ $certificat->inscription->compte->prenom }} {{ $certificat->inscription->compte->nom }}</strong>
        </p>
        <p class="text-muted text-sm" style="margin-bottom: 0;">
            📅 Délivré le {{ \Carbon\Carbon::parse($certificat->date_emission)->format('d/m/Y') }}
            &nbsp;·&nbsp;
            🏢 {{ $certificat->inscription->formation->centre->nom }}
        </p>

        <hr class="divider">

        <div style="background: rgba(0,0,0,0.3); border-radius: var(--radius-md); padding: 1rem; font-size: 0.72rem; word-break: break-all; text-align: left; color: var(--text-muted);">
            <div style="margin-bottom: 0.35rem;"><strong style="color: var(--text-main);">UUID :</strong> {{ $certificat->uuid_public }}</div>
            <div><strong style="color: var(--text-main);">Hash de vérification :</strong> {{ $certificat->hash_verification }}</div>
        </div>

        <div class="mt-6">
            <a href="{{ url('/formations') }}" class="btn btn-ghost" style="width: 100%; justify-content: center;">← Retour au catalogue</a>
        </div>
    </div>
</div>
</body>
</html>