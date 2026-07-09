@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h1>Catalogue des Formations</h1>
    <p>Découvrez nos formations certifiantes et montez en compétences.</p>
</div>

<div class="grid grid-cols-2">
    @foreach($formations as $formation)
    <div class="glass-panel">
        <div class="flex justify-between items-center mb-4">
            <h3>{{ $formation->titre }}</h3>
            <span class="badge">{{ $formation->centre->nom }}</span>
        </div>
        <p>{{ Str::limit($formation->description, 100) }}</p>
        
        <div class="mt-4 flex justify-between items-center">
            <span class="text-muted" style="font-size: 0.85rem;">Du {{ $formation->date_debut }} au {{ $formation->date_fin }}</span>
            <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-primary">Voir les détails</a>
        </div>
    </div>
    @endforeach
</div>
@endsection