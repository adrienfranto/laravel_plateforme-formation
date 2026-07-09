<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreInscriptionRequest extends FormRequest {
    public function authorize() { return true; }
    public function rules() {
        return []; // Pas de payload complexe attendu pour l'instant
    }
}
