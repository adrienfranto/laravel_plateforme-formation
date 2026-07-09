@extends('layouts.app')
@section('title', 'Centres de Formation — FormationPro')

@section('content')
<div class="page-hero">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="gradient-title">Centres de Formation</h1>
            <p>Gérez les centres partenaires où se déroulent les formations.</p>
        </div>
        <a href="{{ route('centres.create') }}" class="btn btn-primary">
            ➕ Nouveau Centre
        </a>
    </div>
</div>

<div class="glass-panel">
    @if($centres->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--surface-border);">
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Nom du centre</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Ville</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Adresse</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Formations liées</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($centres as $centre)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem; font-weight: 600;">{{ $centre->nom }}</td>
                            <td style="padding: 1rem;">
                                <span class="badge badge-primary">📍 {{ $centre->ville }}</span>
                            </td>
                            <td style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">{{ $centre->adresse }}</td>
                            <td style="padding: 1rem;">
                                <span class="stat-pill" style="font-size: 0.75rem;">{{ $centre->formations_count }} formation(s)</span>
                            </td>
                            <td style="padding: 1rem; text-align: right;">
                                <form action="{{ route('centres.destroy', $centre) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce centre ?');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.75rem; font-size: 0.8rem;" {{ $centre->formations_count > 0 ? 'disabled' : '' }} title="{{ $centre->formations_count > 0 ? 'Impossible de supprimer un centre lié à des formations' : 'Supprimer' }}">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center" style="padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🏢</div>
            <h2>Aucun centre disponible</h2>
            <p class="text-muted">Créez le premier centre pour commencer à proposer des formations.</p>
        </div>
    @endif
</div>
@endsection
