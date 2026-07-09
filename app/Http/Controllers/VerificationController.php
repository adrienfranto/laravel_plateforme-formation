<?php

namespace App\Http\Controllers;

use App\Services\CertificatService;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('verify.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string'
        ]);

        return redirect()->to('/verify/' . trim($request->uuid));
    }

    public function show($uuid, CertificatService $certificatService)
    {
        $certificat = $certificatService->verifierCertificat($uuid);

        if (!$certificat) {
            abort(404, 'Certificat introuvable');
        }

        return view('verify.show', compact('certificat'));
    }
}
