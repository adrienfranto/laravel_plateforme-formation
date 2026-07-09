<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Inscription extends Model {
    protected $guarded = [];
    public function compte() { return $this->belongsTo(Compte::class); }
    public function formation() { return $this->belongsTo(Formation::class); }
    public function certificat() { return $this->hasOne(Certificat::class); }
}
