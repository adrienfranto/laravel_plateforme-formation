@extends('layouts.app')
@section('title', 'Mes Certificats — FormationPro')

@section('content')
<div class="page-hero">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="gradient-title">Mes Certificats</h1>
            <p>Retrouvez ici tous les certificats que vous avez obtenus.</p>
        </div>
        <span class="stat-pill">🎓 {{ $certificats->count() }} certificat(s)</span>
    </div>
</div>

@if($certificats->count() > 0)
    <div class="grid grid-cols-2" style="gap: 1.5rem;">
        @foreach($certificats as $certificat)
            <div class="glass-panel" style="display: flex; flex-direction: column; padding: 2rem; border-top: 4px solid var(--primary);">
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div style="font-size: 2.5rem; line-height: 1;">🏆</div>
                        <span class="badge badge-success">Validé</span>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; line-height: 1.4;">
                        {{ $certificat->inscription->formation->titre }}
                    </h3>
                    <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 1.5rem;">
                        Délivré le {{ \Carbon\Carbon::parse($certificat->date_emission)->format('d/m/Y') }}
                    </p>
                    <div style="background: rgba(0,0,0,0.2); padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.05); margin-bottom: 1.5rem;">
                        <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Numéro de certification (UUID)</div>
                        <code style="font-size: 0.85rem; color: #60a5fa; user-select: all;">{{ $certificat->uuid_public }}</code>
                    </div>
                </div>
                <div>
                    <a href="{{ url('/verify/'.$certificat->uuid_public) }}" class="btn btn-primary w-full" style="justify-content: center; padding: 0.75rem;">
                        📄 Voir le certificat public
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="glass-panel text-center" style="padding: 4rem 2rem;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
        <h2>Aucun certificat pour le moment</h2>
        <p class="text-muted">Inscrivez-vous à une formation et allez jusqu'au bout pour obtenir votre premier certificat.</p>
        <a href="{{ route('formations.index') }}" class="btn btn-primary mt-4" style="display: inline-flex;">Parcourir les formations</a>
    </div>
@endif
@endsection
