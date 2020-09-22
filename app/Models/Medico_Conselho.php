<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico_Conselho extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_medico', 'id_conselho', 'numero_conselho'
    ];
}
