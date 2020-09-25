<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MedicoController extends Controller
{
    public function insert(Request $request)
    {
        //validações
        $validate = Validator::make(
            $request->all(),
            [
                'nome_completo' => 'string',
                'login' => 'string',
                'password' => '|string|min:6',
                'email' => 'string|email',
                'id_cargo' => 'int',
                'conselho' => 'string',
                'id_usuario' => 'int',
                'id_conselho' => 'int',
                'numero_conselho' => 'int'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['message', 'Dados informados com erro!'], 400);
        }

        //infos body
        $nome_completo = $request->input('nome_completo');
        $login = $request->input('login');
        $password = $request->input('password');
        $email = $request->input('email');
        $id_cargo = $request->input('id_cargo');
        $conselho = $request->input('conselho');
        $id_usuario = $request->input('id_usuario');
        $id_conselho = $request->input('id_conselho');
        $numero_conselho = $request->input('numero_conselho');

        //cadastrar novo usuario
        if(!$id_usuario){
            $sql = "INSERT INTO 
                    usuarios ( nome_completo, login, password, email, id_cargo )
                VALUES
                    ( '$nome_completo', '$login', '$password', '$email', $id_cargo )";

            DB::insert($sql);
        }

        //select infos user
        $sqlInfoUser = "SELECT
                            * 
                        FROM
                            usuarios 
                        WHERE
                            nome_completo = '$nome_completo'
                        AND 
                            login = '$login'
                        AND 
                            email = '$email'
                        AND 
                            id_cargo = $id_cargo";
        $user = DB::selectOne($sqlInfoUser);

        //cadastrar novo conselho
        if(!$id_conselho){
            $sql = "INSERT INTO 
                    conselho ( conselho )
                VALUES
                    ('$conselho')";

            DB::insert($sql);
        }

        //switch sql insert medico
        $sqlMedic = "INSERT INTO 
                        medico ( id_usuario )
                    VALUES";
        switch($id_usuario){
            case !null:
                $this->$sqlMedic = $sqlMedic .  " ( $id_usuario )";
            break;
            case null:
                $this->$sqlMedic = $sqlMedic . " ( $user->id )";
            break;
        }

        DB::insert($this->$sqlMedic);

        //switch info medicos
        $sqlInfo = "SELECT
                        * 
                    FROM
                        medico 
                    WHERE
                        id_usuario =";
        switch($id_usuario){
            case !null:
                $this->$sqlInfo = $sqlInfo . "$id_usuario";
            break;
            case null:
                $this->$sqlInfo = $sqlInfo . "$user->id";
            break;
        }

        $medic = DB::selectOne($this->$sqlInfo);

        //switch info conselho
        $infoConselho = "SELECT
                            * 
                        FROM
                            conselho 
                        WHERE
                            conselho = '$conselho'
                        LIMIT 0,1";

        $conselhoInfo = DB::selectOne($infoConselho);

        //switch sql insert conselho_medico
        $sqlConMedic = "INSERT INTO 
                            medico_conselho ( id_medico, id_conselho, numero_conselho )
                        VALUES";
        switch($id_conselho){
            case !null:
                $this->$sqlConMedic = $sqlConMedic . "( $medic->id, $id_conselho, $numero_conselho )";
            break;
            case null:
                $this->$sqlConMedic = $sqlConMedic . "( $medic->id, $conselhoInfo->id, $numero_conselho )";
            break;
        }

        DB::insert($this->$sqlConMedic);

        return response()->json(['message' => 'Medico cadastrado com sucesso!'], 200);
    }
}
