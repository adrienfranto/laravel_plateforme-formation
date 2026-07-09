<?php

namespace App\Http\Controllers;

use App\Services\CertificatService;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function show($uuid, CertificatService $certificatService)
    {
        $certificat = $certificatService->verifierCertificat($uuid);

        if (!$certificat) {
            abort(404, 'Certificat introuvable');
        }

        return view('verify.show', compact('certificat'));
    }
}
