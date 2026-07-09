@extends('layouts.app')
@section('title', 'Mes Formations & Certificats — FormationPro')

@section('content')
<div class="page-hero">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="gradient-title">Mes Formations</h1>
            <p>Historique de vos formations et certificats obtenus.</p>
        </div>
        <div class="flex gap-2">
            <span class="stat-pill">📖 {{ $inscriptions->count() }} inscription(s)</span>
            <span class="stat-pill">🎓 {{ $certificats->count() }} certificat(s)</span>
        </div>
    </div>
</div>

{{-- ========================= BLOC CERTIFICATS ========================= --}}
@if($certificats->count() > 0)
<div class="glass-panel" style="margin-bottom: 2rem; border-top: 4px solid var(--primary);">
    <h2 style="font-size: 1.2rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
        🏆 <span>Mes Certificats obtenus</span>
    </h2>
    <div class="grid grid-cols-2" style="gap: 1.25rem;">
        @foreach($certificats as $certificat)
            <div style="background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.2); border-radius: var(--radius-md); padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <div class="flex justify-between items-center">
                    <span style="font-size: 1.75rem;">🏆</span>
                    <span class="badge badge-success">Validé</span>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 1rem; margin-bottom: 0.25rem;">{{ $certificat->inscription->formation->titre }}</div>
                    <div class="text-muted text-sm">🏢 {{ $certificat->inscription->formation->centre->nom }}</div>
                    <div class="text-muted text-sm">📅 Émis le {{ \Carbon\Carbon::parse($certificat->date_emission)->format('d/m/Y') }}</div>
                </div>
                <div style="background: rgba(0,0,0,0.2); padding: 0.6rem 0.85rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.2rem;">UUID</div>
                    <code style="font-size: 0.78rem; color: #60a5fa; user-select: all; word-break: break-all;">{{ $certificat->uuid_public }}</code>
                </div>
                <a href="{{ url('/verify/'.$certificat->uuid_public) }}" class="btn btn-primary" style="justify-content: center; font-size: 0.85rem; padding: 0.6rem 1rem;">
                    📄 Voir le certificat public
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- ========================= HISTORIQUE INSCRIPTIONS ========================= --}}
<div class="glass-panel">
    <h2 style="font-size: 1.2rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
        📖 <span>Historique de mes inscriptions</span>
    </h2>

    @if($inscriptions->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($inscriptions as $inscription)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.1rem 1.25rem; background: rgba(255,255,255,0.03); border: 1px solid var(--surface-border); border-radius: var(--radius-md); transition: var(--transition); flex-wrap: wrap; gap: 1rem;"
                onmouseover="this.style.background='rgba(255,255,255,0.06)'"
                onmouseout="this.style.background='rgba(255,255,255,0.03)'"
            >
                <div style="flex: 1; min-width: 200px;">
                    <div style="font-weight: 600; margin-bottom: 0.3rem;">
                        <a href="{{ route('formations.show', $inscription->formation->id) }}" style="color: var(--text-main); text-decoration: none;">
                            {{ $inscription->formation->titre }}
                        </a>
                    </div>
                    <div class="text-muted text-sm" style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <span>🏢 {{ $inscription->formation->centre->nom }}</span>
                        <span>👨‍🏫 {{ $inscription->formation->formateur->prenom }} {{ $inscription->formation->formateur->nom }}</span>
                        <span>📅 {{ \Carbon\Carbon::parse($inscription->formation->date_debut)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($inscription->formation->date_fin)->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($inscription->statut === 'cloture')
                        <span class="badge badge-danger">Clôturée</span>
                        @if($inscription->certificat)
                            <a href="{{ url('/verify/'.$inscription->certificat->uuid_public) }}" class="btn btn-primary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                                🎓 Voir le certificat
                            </a>
                        @endif
                    @else
                        <span class="badge badge-success">En cours</span>
                        <a href="{{ route('formations.show', $inscription->formation->id) }}" class="btn btn-ghost" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                            Voir →
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center" style="padding: 3rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
            <h2 style="margin-bottom: 0.5rem;">Aucune inscription</h2>
            <p class="text-muted">Vous n'êtes inscrit à aucune formation pour le moment.</p>
            <a href="{{ route('formations.index') }}" class="btn btn-primary mt-4" style="display: inline-flex;">
                🚀 Parcourir le catalogue
            </a>
        </div>
    @endif
</div>

{{-- EXPLICATION si 0 certificats mais des inscriptions --}}
@if($certificats->count() === 0 && $inscriptions->count() > 0)
<div style="margin-top: 1.5rem; padding: 1rem 1.25rem; background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); border-radius: var(--radius-md); display: flex; gap: 0.75rem; align-items: flex-start;">
    <span style="font-size: 1.2rem;">ℹ️</span>
    <div>
        <strong style="display: block; margin-bottom: 0.25rem;">Comment obtenir un certificat ?</strong>
        <p class="text-muted text-sm" style="margin: 0;">
            Les certificats sont générés automatiquement lorsque le formateur <strong>clôture la formation</strong>. 
            Une fois la formation terminée et validée par le formateur, vous recevrez votre certificat ici.
        </p>
    </div>
</div>
@endif
@endsection
