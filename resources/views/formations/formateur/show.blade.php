@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <div class="flex justify-between items-center mb-4">
        <h1>Espace Formateur : {{ $formation->titre }}</h1>
        <span class="badge">{{ $formation->centre->nom }}</span>
    </div>
    
    <p>{{ $formation->description }}</p>
    <div class="mt-4 mb-4">
        <span class="text-muted">Période : Du {{ $formation->date_debut }} au {{ $formation->date_fin }}</span>
    </div>

    <hr style="border-color: var(--surface-border); margin: 2rem 0;">

    <div class="flex justify-between items-center mb-4">
        <h2>Apprenants Inscrits ({{ $inscriptions->count() }})</h2>
        @if($inscriptions->count() > 0 && !$inscriptions->where('statut', 'cloture')->count())
            <form action="{{ url('/formations/'.$formation->id.'/cloturer') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" onclick="return confirm('Clôturer la formation et générer les certificats ?')">Clôturer la formation</button>
            </form>
        @endif
    </div>

    @if($inscriptions->count() > 0)
        <div class="grid grid-cols-1">
            @foreach($inscriptions as $inscription)
                <div class="glass-panel" style="padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ $inscription->compte->prenom }} {{ $inscription->compte->nom }}</strong>
                        <span class="text-muted ml-2">{{ $inscription->compte->telephone }}</span>
                    </div>
                    <span class="badge {{ $inscription->statut === 'cloture' ? 'closed' : 'active' }}">
                        {{ ucfirst($inscription->statut) }}
                    </span>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Aucun apprenant n'est actuellement inscrit à cette formation.</p>
    @endif
</div>
@endsection