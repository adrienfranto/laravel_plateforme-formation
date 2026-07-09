<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Formation extends Model {
    use HasFactory;
    protected $guarded = [];
    public function centre() { return $this->belongsTo(Centre::class); }
    public function formateur() { return $this->belongsTo(Compte::class, 'formateur_id'); }
    public function inscriptions() { return $this->hasMany(Inscription::class); }
}
