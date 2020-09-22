<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda_Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_medico', 'id_agenda'
    ];
}
