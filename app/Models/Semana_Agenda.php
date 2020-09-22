<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semana_Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_semana', 'id_agenda'
    ];
}
