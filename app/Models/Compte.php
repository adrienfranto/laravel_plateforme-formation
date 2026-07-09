<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compte extends Authenticatable
{
    use HasFactory;
    
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'compte_role');
    }

    public function hasRole(string $code): bool
    {
        return $this->roles->contains('code', $code);
    }
}
