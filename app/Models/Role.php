<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends Model {
    protected $guarded = [];
    public function comptes() { return $this->belongsToMany(Compte::class, 'compte_role'); }
}
