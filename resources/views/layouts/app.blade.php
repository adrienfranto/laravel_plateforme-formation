<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FormationPro')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- Particules de fond décoratifs --}}
<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div class="container">
    {{-- HEADER --}}
    <header class="header-nav">
        <a href="{{ route('formations.index') }}" class="brand" style="text-decoration: none;">
            <span class="brand-icon">🎓</span>
            FormationPro
        </a>
        <nav style="display: flex; align-items: center; gap: 1rem;">
            @auth
                <a href="{{ route('formations.index') }}" class="nav-link">Catalogue</a>
                <div class="user-chip">
                    <span class="user-avatar">{{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}</span>
                    <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    <span class="badge">{{ Auth::user()->roles->first()?->libelle ?? 'Invité' }}</span>
                </div>
                <form action="{{ url('/logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
            @endauth
        </nav>
    </header>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-transition>
            <span>✅ {{ session('success') }}</span>
            <button @click="show = false" style="background: none; border: none; color: inherit; cursor: pointer; font-size: 1.1rem;">✕</button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" x-data="{ show: true }" x-show="show" x-transition>
            <div>
                <strong>⚠️ Erreurs dans le formulaire :</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" style="background: none; border: none; color: inherit; cursor: pointer; font-size: 1.1rem; align-self: flex-start;">✕</button>
        </div>
    @endif

    {{-- CONTENU PRINCIPAL --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer style="text-align: center; margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--surface-border); color: var(--text-muted); font-size: 0.85rem;">
        <p>© {{ date('Y') }} FormationPro — Plateforme de Formation Certifiante</p>
    </footer>
</div>
</body>
</html>