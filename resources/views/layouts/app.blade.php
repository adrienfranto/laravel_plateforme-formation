<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme de Formation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <header class="header-nav glass-panel mb-4">
            <div class="brand">FormationPro</div>
            <nav>
                <a href="{{ route('formations.index') }}" class="btn">Catalogue</a>
                @auth
                    <span class="ml-4 text-muted">Connecté en tant que {{ Auth::user()->prenom }}</span>
                @endauth
            </nav>
        </header>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="glass-panel mb-4" style="border-left: 4px solid var(--success);">
                <div class="flex justify-between items-center">
                    <p style="margin: 0; color: var(--success);">{{ session('success') }}</p>
                    <button @click="show = false" class="btn">✕</button>
                </div>
            </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>