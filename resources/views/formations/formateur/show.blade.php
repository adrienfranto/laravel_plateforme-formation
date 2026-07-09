@extends('layouts.app')
@section('title', 'Espace Formateur — ' . $formation->titre)

@section('content')
<div class="mb-4">
    <a href="{{ route('formations.index') }}" class="btn btn-ghost" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">← Retour au catalogue</a>
</div>

{{-- Header formation --}}
<div class="glass-panel" style="margin-bottom: 1.5rem;">
    <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <div>
            <span class="badge badge-purple mb-2">👨‍🏫 Espace Formateur</span>
            <h1 style="font-size: 1.75rem;">{{ $formation->titre }}</h1>
        </div>
        <div class="flex gap-2" style="flex-wrap: wrap;">
            <span class="stat-pill">🏢 {{ $formation->centre->nom }}</span>
            <span class="stat-pill">📅 {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') }}</span>
        </div>
    </div>
    <p>{{ $formation->description }}</p>
</div>

{{-- Panel inscrits --}}
<div class="glass-panel">
    <div class="flex justify-between items-center mb-6" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin-bottom: 0.25rem;">Apprenants inscrits</h2>
            <p style="margin: 0;" class="text-sm">
                <span class="badge badge-primary">{{ $inscriptions->count() }} inscrit(s)</span>
            </p>
        </div>

        @if($inscriptions->count() > 0 && !$inscriptions->where('statut', 'cloture')->count())
            <form action="{{ url('/formations/'.$formation->id.'/cloturer') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="btn btn-success"
                    onclick="return confirm('Clôturer la formation et générer les certificats pour tous les apprenants ?')"
                >
                    🎓 Clôturer et délivrer les certificats
                </button>
            </form>
        @elseif($inscriptions->where('statut', 'cloture')->count())
            <span class="badge badge-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Formation clôturée</span>
        @endif
    </div>

    @if($inscriptions->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($inscriptions as $inscription)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; background: rgba(255,255,255,0.04); border: 1px solid var(--surface-border); border-radius: var(--radius-md); transition: var(--transition);">
                    <div class="flex items-center gap-4">
                        <div class="user-avatar" style="width: 38px; height: 38px; font-size: 0.9rem;">
                            {{ strtoupper(substr($inscription->compte->prenom, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600;">{{ $inscription->compte->prenom }} {{ $inscription->compte->nom }}</div>
                            <div class="text-muted text-sm">{{ $inscription->compte->telephone }}</div>
                        </div>
                    </div>
                    <span class="badge {{ $inscription->statut === 'cloture' ? 'badge-danger' : 'badge-success' }}">
                        {{ ucfirst($inscription->statut) }}
                    </span>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center" style="padding: 3rem 0;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">📭</div>
            <p class="text-muted">Aucun apprenant n'est encore inscrit à cette formation.</p>
        </div>
    @endif
</div>
@endsection