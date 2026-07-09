<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat — {{ $certificat->inscription->formation->titre }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f0f4ff;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .toolbar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            align-items: center;
        }

        .btn {
            padding: 0.65rem 1.4rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-download { background: linear-gradient(135deg, #3b82f6, #6366f1); color: white; }
        .btn-download:hover { opacity: 0.88; }
        .btn-back { background: #e2e8f0; color: #475569; }
        .btn-back:hover { background: #cbd5e1; }

        /* ===== CERTIFICAT ===== */
        .certificate {
            width: 900px;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            position: relative;
        }

        .cert-border {
            border: 8px solid transparent;
            border-image: linear-gradient(135deg, #1e40af, #7c3aed, #1e40af) 1;
            margin: 12px;
            border-radius: 2px;
        }

        .cert-inner {
            padding: 3rem 4rem;
            text-align: center;
            position: relative;
        }

        .cert-bg-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 200px;
            opacity: 0.03;
            pointer-events: none;
        }

        .cert-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .cert-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.3rem;
            font-weight: 800;
            color: #1e3a8a;
        }

        .cert-badge {
            background: linear-gradient(135deg, #1e40af, #7c3aed);
            color: white;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .cert-title {
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .cert-main-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 900;
            background: linear-gradient(135deg, #1e40af, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .cert-text {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .cert-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0.5rem 0 1.5rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 1rem;
        }

        .cert-formation {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 0.4rem;
        }

        .cert-formation strong {
            font-size: 1.35rem;
            color: #1e293b;
            display: block;
            font-weight: 700;
            margin-top: 0.25rem;
        }

        .cert-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin: 2.5rem 0;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            text-align: left;
        }

        .meta-item label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
        }
        .meta-item span {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        .note-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1rem;
        }
        .note-good { background: #dcfce7; color: #15803d; }
        .note-avg  { background: #fef9c3; color: #a16207; }
        .note-fail { background: #fee2e2; color: #b91c1c; }

        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e2e8f0;
        }

        .signature-block { text-align: center; }
        .signature-line {
            width: 180px;
            border-top: 2px solid #0f172a;
            margin: 0.5rem auto;
        }
        .signature-label { font-size: 0.85rem; color: #64748b; }
        .signature-name  { font-size: 0.9rem; font-weight: 700; color: #0f172a; }

        .uuid-block {
            font-size: 0.72rem;
            color: #94a3b8;
            text-align: right;
        }
        .uuid-block code { font-family: monospace; font-size: 0.7rem; color: #6366f1; }

        .seal {
            width: 80px;
            height: 80px;
            border: 4px solid #1e40af;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 0.65rem;
            font-weight: 700;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: center;
            line-height: 1.3;
        }

        @media print {
            body { background: white; padding: 0; }
            .toolbar { display: none; }
            .certificate { box-shadow: none; width: 100%; }
        }
    </style>
</head>
<body>

@if(!request()->has('embed'))
<div class="toolbar">
    @auth
    <a href="{{ url()->previous() }}" class="btn btn-back">← Retour</a>
    @endauth
    <button onclick="window.print()" class="btn btn-download">📥 Télécharger en PDF</button>
</div>
@endif

<div class="certificate">
    <div class="cert-border">
        <div class="cert-inner">
            <div class="cert-bg-logo">🎓</div>

            {{-- Header --}}
            <div class="cert-header">
                <div class="cert-logo">🎓 FormationPro</div>
                <span class="cert-badge">Certificat Officiel</span>
            </div>

            {{-- Titre --}}
            <div class="cert-title">Certificat de Réussite</div>
            <div class="cert-main-title">Attestation de Formation</div>

            {{-- Nom apprenant --}}
            <p class="cert-text">Délivré à</p>
            <div class="cert-name">
                {{ $certificat->inscription->compte->prenom }} {{ $certificat->inscription->compte->nom }}
            </div>

            {{-- Formation --}}
            <p class="cert-formation">
                Pour avoir suivi et réussi avec succès la formation
                <strong>{{ $certificat->inscription->formation->titre }}</strong>
            </p>

            {{-- Meta grid --}}
            <div class="cert-meta">
                <div class="meta-item">
                    <label>Centre</label>
                    <span>{{ $certificat->inscription->formation->centre->nom }}</span>
                </div>
                <div class="meta-item">
                    <label>Période</label>
                    <span>
                        {{ \Carbon\Carbon::parse($certificat->inscription->formation->date_debut)->format('d/m/Y') }}
                        au
                        {{ \Carbon\Carbon::parse($certificat->inscription->formation->date_fin)->format('d/m/Y') }}
                    </span>
                </div>
                <div class="meta-item">
                    <label>Date d'émission</label>
                    <span>{{ \Carbon\Carbon::parse($certificat->date_emission)->format('d/m/Y') }}</span>
                </div>
                @if($certificat->inscription->note !== null)
                <div class="meta-item">
                    <label>Note obtenue</label>
                    <span>
                        <span class="note-badge {{ $certificat->inscription->note >= 14 ? 'note-good' : ($certificat->inscription->note >= 10 ? 'note-avg' : 'note-fail') }}">
                            {{ number_format($certificat->inscription->note, 2) }} / 20
                        </span>
                    </span>
                </div>
                @endif
                @if($certificat->inscription->commentaire)
                <div class="meta-item" style="grid-column: span 2;">
                    <label>Commentaire du formateur</label>
                    <span style="font-weight: 400; font-size: 0.9rem; color: #475569;">{{ $certificat->inscription->commentaire }}</span>
                </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="cert-footer">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-name">
                        {{ $certificat->inscription->formation->formateur->prenom }}
                        {{ $certificat->inscription->formation->formateur->nom }}
                    </div>
                    <div class="signature-label">Formateur référent</div>
                </div>

                <div class="seal">
                    <div>Formation</div>
                    <div>Pro</div>
                    <div>✓</div>
                </div>

                <div class="uuid-block">
                    <div>N° de certification</div>
                    <code>{{ $certificat->uuid_public }}</code>
                    <div style="margin-top: 0.4rem;">Vérifiable sur : <strong>{{ url('/verify/'.$certificat->uuid_public) }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
