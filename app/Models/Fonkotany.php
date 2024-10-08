<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonkotany extends Model
{
    protected $table = 'fonkotany';
    protected $primaryKey = 'id_fonkotany';
    public $incrementing = true;
    
    protected $fillable = [
        'code_fonkotany',
        'nom_fonkotany',
        'id_commune'
    ];

    use HasFactory;

    public function commune() {
        return $this->belongsTo(Commune::class, 'id_commune');
    }
}
