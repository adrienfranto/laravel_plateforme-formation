<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Certificat extends Model {
    protected $guarded = [];
    public function inscription() { return $this->belongsTo(Inscription::class); }
}
