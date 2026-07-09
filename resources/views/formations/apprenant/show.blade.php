@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <h1>{{ $formation->titre }}</h1>
    <p>{{ $formation->description }}</p>
    
    <div class="mt-4 mb-4">
        <span class="badge">{{ $formation->centre->nom }}</span>
        <span class="text-muted ml-4">Du {{ $formation->date_debut }} au {{ $formation->date_fin }}</span>
    </div>

    <hr style="border-color: var(--surface-border); margin: 2rem 0;">

    @if(!$inscription)
        <div x-data="{ confirming: false }">
            <button x-show="!confirming" @click="confirming = true" class="btn btn-primary">M'inscrire à cette formation</button>
            
            <div x-show="confirming" class="glass-panel mt-4" style="border-color: var(--primary);">
                <h3>Confirmer l'inscription ?</h3>
                <p>Vous êtes sur le point de vous inscrire à cette session. Cette action est irréversible.</p>
                <div class="flex">
                    <form action="{{ url('/formations/'.$formation->id.'/inscriptions') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Oui, m'inscrire</button>
                    </form>
                    <button @click="confirming = false" class="btn ml-4">Annuler</button>
                </div>
            </div>
        </div>
    @else
        <div class="glass-panel" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3);">
            <h3>Vous êtes inscrit !</h3>
            <p>Statut actuel : <strong>{{ ucfirst($inscription->statut) }}</strong></p>
            @if($inscription->statut === 'cloture' && $inscription->certificat)
                <div class="mt-4">
                    <a href="{{ url('/verify/'.$inscription->certificat->uuid_public) }}" class="btn btn-primary">Voir mon certificat</a>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection