<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreCompteRequest extends FormRequest {
    public function authorize() { return true; }
    public function rules() {
        return [
            'telephone' => 'required|string|unique:comptes',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
