<?php

namespace App\Services;

use App\Models\Certificat;
use App\Models\Inscription;
use Illuminate\Support\Str;

class CertificatService
{
    public function genererCertificat(Inscription $inscription)
    {
        // 1. Générer UUID public
        $uuid = Str::uuid()->toString();
        $dateEmission = now();

        // 2. Générer hash de vérification (simple signature)
        $hash = hash('sha256', $uuid . $inscription->id . $dateEmission->timestamp . config('app.key'));

        // 3. Créer le certificat
        return Certificat::create([
            'uuid_public' => $uuid,
            'inscription_id' => $inscription->id,
            'date_emission' => $dateEmission,
            'hash_verification' => $hash
        ]);
    }

    public function verifierCertificat(string $uuid)
    {
        return Certificat::with(['inscription.compte', 'inscription.formation'])->where('uuid_public', $uuid)->first();
    }
}