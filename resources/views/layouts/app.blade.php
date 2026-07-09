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

<div class="app-layout">
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('formations.index') }}" class="brand" style="text-decoration: none;">
                <span class="brand-icon">🎓</span>
                <span class="brand-text">FormationPro</span>
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <h4 class="nav-section-title">Menu</h4>
                <a href="{{ route('formations.index') }}" class="sidebar-link {{ request()->routeIs('formations.*') ? 'active' : '' }}">
                    <span class="icon">📚</span> Catalogue
                </a>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="icon">📈</span> Tableau de bord
                    </a>
                    @if(Auth::user()->roles->contains('code', 'formateur'))
                        <a href="{{ route('centres.index') }}" class="sidebar-link {{ request()->routeIs('centres.*') ? 'active' : '' }}">
                            <span class="icon">🏢</span> Centres
                        </a>
                        <a href="{{ route('comptes.index') }}" class="sidebar-link {{ request()->routeIs('comptes.*') ? 'active' : '' }}">
                            <span class="icon">👥</span> Utilisateurs
                        </a>
                    @else
                        <a href="{{ route('certificats.index') }}" class="sidebar-link {{ request()->routeIs('certificats.*') ? 'active' : '' }}">
                            <span class="icon">🎓</span> Mes Certificats
                        </a>
                        <a href="{{ route('parrainages.index') }}" class="sidebar-link {{ request()->routeIs('parrainages.*') ? 'active' : '' }}">
                            <span class="icon">🤝</span> Parrainages
                        </a>
                    @endif
                @endauth
            </div>
        </nav>

        <div class="sidebar-footer">
            @auth
                <div class="user-chip-sidebar">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                        <div class="role badge">{{ Auth::user()->roles->first()?->libelle ?? 'Invité' }}</div>
                    </div>
                </div>
                <form action="{{ url('/logout') }}" method="POST" style="margin-top: 1rem; width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-ghost w-full">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost w-full mb-2">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary w-full">S'inscrire</a>
            @endauth
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="main-content">
        <div class="container-inner">
            {{-- HEADER MOBILE ONLY --}}
            <header class="mobile-header">
                <a href="{{ route('formations.index') }}" class="brand" style="text-decoration: none;">
                    <span class="brand-icon">🎓</span>
                </a>
                <button class="btn btn-ghost btn-menu" onclick="document.querySelector('.sidebar').classList.toggle('show')">
                    ☰
                </button>
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

            {{-- VIEW CONTENT --}}
            <main>
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer style="text-align: center; margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--surface-border); color: var(--text-muted); font-size: 0.85rem;">
                <p>© {{ date('Y') }} FormationPro — Plateforme de Formation Certifiante</p>
            </footer>
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>