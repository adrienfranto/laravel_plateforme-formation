<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreFormationRequest extends FormRequest {
    public function authorize() { return true; }
    public function rules() {
        return [
            'titre' => 'required|string',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'centre_id' => 'required|exists:centres,id',
            'formateur_id' => 'required|exists:comptes,id'
        ];
    }
}
