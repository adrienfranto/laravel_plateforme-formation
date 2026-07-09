@extends('layouts.app')
@section('title', 'Vérifier un Certificat — FormationPro')

@section('content')
<div class="flex" style="justify-content: center; min-height: 70vh; align-items: center;">
    <div class="glass-panel text-center" style="max-width: 600px; width: 100%; padding: 4rem 3rem;">
        
        <div style="display:inline-flex;align-items:center;justify-content:center;width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#a855f7);font-size:2rem;margin-bottom:1.5rem;box-shadow:0 0 20px rgba(59,130,246,0.3);">
            🛡️
        </div>
        
        <h1 class="gradient-title" style="font-size: 2.25rem; margin-bottom: 0.5rem;">Vérification de Certificat</h1>
        <p class="text-muted" style="margin-bottom: 2.5rem; font-size: 1.05rem;">
            Vérifiez l'authenticité d'un certificat émis par FormationPro.
        </p>

        <form action="{{ route('verify.search') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <input type="text" name="uuid" required placeholder="Entrez le numéro UUID du certificat..." class="form-input" style="font-family: monospace; font-size: 1.1rem; padding: 1rem; text-align: center; letter-spacing: 1px;" value="{{ old('uuid') }}">
                @error('uuid')
                    <p style="color:#fca5a5; font-size:0.85rem; margin-top:0.5rem; text-align: left;">⚠️ {{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-full" style="justify-content: center; padding: 1rem; font-size: 1.1rem;">
                🔍 Lancer la vérification
            </button>
        </form>

        <div style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem;">
            <p class="text-muted" style="font-size: 0.85rem; line-height: 1.5;">
                Nos certificats sont enregistrés numériquement. La vérification garantit que le document n'a pas été falsifié et a bien été délivré par nos centres partenaires.
            </p>
        </div>
    </div>
</div>
@endsection
