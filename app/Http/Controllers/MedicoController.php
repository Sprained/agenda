<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            $user = DB::insert($sql);
        }

        //cadastrar novo conselho
        if(!$id_conselho){
            $sql = "INSERT INTO 
                    conselho ( conselho )
                VALUES
                    ('$conselho')";

            $conselho = DB::insert($sql);
        }

        //switch sql insert medico
        $sqlMedic = "";
        switch($id_usuario){
            case $id_usuario:
                return $this->$sqlMedic = "INSERT INTO 
                                medico ( id_usuario )
                            VALUES
                                ( $id_usuario )";
            case !$id_usuario:
                return $this->$sqlMedic = "INSERT INTO 
                                medico ( id_usuario )
                            VALUES
                                ( $user->id )";
        }

        DB::insert($sqlMedic);

        //switch info medicos
        $sqlInfo = "";
        switch($id_usuario){
            case $id_usuario:
                return $this->$sqlInfo = "";
        }

        //switch sql insert conselho_medico
        $sqlConMedic = "";
        switch($id_conselho){
            case $id_conselho:
                return $this->$sqlConMedic = "INSERT INTO 
                                        medico_conselho ( id_medico, id_conselho, numero_conselho )
                                    VALUES
                                        ( $medic->id, $id_conselho, $numero_conselho )";
        }
    }
}
