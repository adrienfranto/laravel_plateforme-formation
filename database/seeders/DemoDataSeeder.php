<?php

namespace Database\Seeders;

use App\Models\Centre;
use App\Models\Compte;
use App\Models\Formation;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roleApprenant = Role::create(['code' => 'apprenant', 'libelle' => 'Apprenant']);
        $roleFormateur = Role::create(['code' => 'formateur', 'libelle' => 'Formateur']);

        // 2. Centres
        $centreParis = Centre::create(['nom' => 'Centre Paris 11', 'ville' => 'Paris']);
        $centreLyon = Centre::create(['nom' => 'Centre Lyon', 'ville' => 'Lyon']);

        // 3. Comptes
        $formateur = Compte::factory()->create([
            'prenom' => 'Jean', 'nom' => 'Formateur', 'telephone' => '0600000001', 'password' => Hash::make('password')
        ]);
        $formateur->roles()->attach($roleFormateur->id);

        $apprenant = Compte::factory()->create([
            'prenom' => 'Alice', 'nom' => 'Apprenante', 'telephone' => '0600000002', 'password' => Hash::make('password')
        ]);
        $apprenant->roles()->attach($roleApprenant->id);

        // 4. Formations
        Formation::factory()->create([
            'titre' => 'Laravel Avancé',
            'centre_id' => $centreParis->id,
            'formateur_id' => $formateur->id
        ]);
        
        Formation::factory()->create([
            'titre' => 'Initiation React',
            'centre_id' => $centreLyon->id,
            'formateur_id' => $formateur->id
        ]);
    }
}
