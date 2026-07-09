@extends('layouts.app')
@section('title', 'Utilisateurs — FormationPro')

@section('content')
<div class="page-hero">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="gradient-title">Utilisateurs inscrits</h1>
            <p>Consultez la liste des comptes de la plateforme.</p>
        </div>
        <span class="stat-pill">👥 {{ $comptes->count() }} utilisateur(s)</span>
    </div>
</div>

<div class="glass-panel">
    @if($comptes->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--surface-border);">
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Utilisateur</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Téléphone</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Rôle</th>
                        <th style="padding: 1rem; color: var(--text-muted); font-weight: 600;">Inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comptes as $compte)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem; font-weight: 600;">
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ strtoupper(substr($compte->prenom, 0, 1)) }}
                                    </div>
                                    <div>
                                        {{ $compte->prenom }} {{ $compte->nom }}
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{ $compte->telephone }}</td>
                            <td style="padding: 1rem;">
                                @foreach($compte->roles as $role)
                                    <span class="badge {{ $role->code === 'formateur' ? 'badge-purple' : 'badge-primary' }}">
                                        {{ $role->libelle }}
                                    </span>
                                @endforeach
                            </td>
                            <td style="padding: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                                {{ $compte->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center" style="padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
            <h2>Aucun utilisateur</h2>
        </div>
    @endif
</div>
@endsection
