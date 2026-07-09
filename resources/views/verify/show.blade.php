<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de Certificat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="display: flex; justify-content: center; align-items: center;">
    <div class="container" style="max-width: 600px; text-align: center;">
        <div class="glass-panel" style="border-top: 4px solid var(--success);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
            <h1 style="color: var(--success); margin-bottom: 0.5rem;">Certificat Valide</h1>
            <p class="text-muted mb-4">Ce document est un certificat officiel délivré par notre plateforme.</p>
            
            <hr style="border-color: var(--surface-border); margin: 1.5rem 0;">
            
            <h2 style="font-size: 1.25rem;">{{ $certificat->inscription->formation->titre }}</h2>
            <p style="margin-bottom: 0.25rem;">Décerné à <strong>{{ $certificat->inscription->compte->prenom }} {{ $certificat->inscription->compte->nom }}</strong></p>
            <p class="text-muted" style="font-size: 0.9rem;">
                Délivré le {{ \Carbon\Carbon::parse($certificat->date_emission)->format('d/m/Y') }}<br>
                Centre : {{ $certificat->inscription->formation->centre->nom }}
            </p>
            
            <div class="mt-4 p-2" style="background: rgba(0,0,0,0.2); border-radius: var(--radius-md); font-size: 0.75rem; word-break: break-all; color: var(--text-muted);">
                <strong>UUID:</strong> {{ $certificat->uuid_public }}<br>
                <strong>Hash de sécurité:</strong> {{ $certificat->hash_verification }}
            </div>

            <div class="mt-4">
                <a href="{{ url('/') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff;">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>