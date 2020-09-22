<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo', 'cpf', 'rg', 'data_nascimento', 'email', 'telefone', 'telefone2'
    ];
}
