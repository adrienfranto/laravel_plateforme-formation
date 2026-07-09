<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Centre extends Model {
    use HasFactory;
    protected $guarded = [];
    public function formations() { return $this->hasMany(Formation::class); }
}
