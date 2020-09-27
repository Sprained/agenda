<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    public function insert(Request $request){
        //validações
        $validate = Validator::make(
            $request-> all(),
            [
                'nome_completo' => 'required|string',
                'cpf' => 'required|int|min:11',
                'rg' => 'required|int',
                // 'data_nascimento' => 'required|date',
                'email' => 'required|string',
                'telefone' => 'required|int',
                'telefone2' => 'int'
            ]
        );

        if($validate->fails()){
            return response()->json(['message' => 'Dados informados com erro!'], 400);
        }

        //infos
        $nome_completo = $request->input('nome_completo');
        $cpf = $request->input('cpf');
        $rg = $request->input('rg');
        $data_nascimento = $request->input('data_nascimento');
        $email = $request->input('email');
        $telefone = $request->input('telefone');
        $telefone2 = $request->input('telefone2');

        switch ($telefone2){
            case !null:
                $sql = "INSERT INTO 
                    paciente ( nome_completo, cpf, rg, data_nascimento, email, telefone, telefone2 )
                VALUES
                    ( '$nome_completo', $cpf, $rg, '$data_nascimento', '$email', $telefone, $telefone2 )";
            break;
            case null:
                $sql = "INSERT INTO 
                    paciente ( nome_completo, cpf, rg, data_nascimento, email, telefone )
                VALUES
                    ( '$nome_completo', $cpf, $rg, '$data_nascimento', '$email', $telefone )";
            break;
        }

        DB::insert($sql);

        return response()->json(['message' => 'Paciente cadastrado com sucesso!'], 200);
    }
}
