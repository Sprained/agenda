<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function insert(Request $request)
    {
        //validação dos dados
        $validate = Validator::make(
            $request->all(),
            [
                'nome_completo' => 'required|string',
                'login' => 'required|string',
                'password' => 'required|string|min:6',
                'email' => 'required|string|email',
                'id_cargo' => 'required|int'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['message' => 'Dados informados com erro!']);
        }

        //campos body
        $nome_completo = $request->input('nome_completo');
        $login = $request->input('login');
        $password = Hash::make($request->input('password'));
        $email = $request->input('email');
        $id_cargo = $request->input('id_cargo');

        //verificação se usuario ja foi cadastrado
        $sqlEmail = "SELECT
                        * 
                    FROM
                        usuarios 
                    WHERE
                        email = '$email'";

        $user = DB::select($sqlEmail);

        if ($user) {
            return response()->json(['message' => 'Email ja cadastrado!'], 400);
        }

        //cadastro novo usuario
        $sql = "INSERT INTO 
                    usuarios ( nome_completo, login, password, email, id_cargo )
                VALUES
                    ( '$nome_completo', '$login', '$password', '$email', $id_cargo )";

        DB::insert($sql);

        return response()->json(['message' => 'Usuario cadastrado com sucesso'], 200);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM 
                    users 
                WHERE
                    id = $id";

        DB::delete($sql);

        return response()->json(['message' => 'Usuario deletado com sucesso'], 200);
    }

    public function update(Request $request, $id)
    {
        //validação dos dados
        $validate = Validator::make(
            $request->all(),
            [
                'nome_completo' => 'required|string',
                'login' => 'required|string',
                'password' => 'required|string|min:6',
                'email' => 'required|string|email',
                'id_cargo' => 'required|int'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['message' => 'Dados informados com erro!'], 400);
        }

        //campos body
        $nome_completo = $request->input('nome_completo');
        $login = $request->input('login');
        $password = Hash::make($request->input('password'));
        $email = $request->input('email');
        $id_cargo = $request->input('id_cargo');

        //verificação se usuario encontra cadastrado
        $sqlEmail = "SELECT
                        * 
                    FROM
                        usuarios 
                    WHERE
                        email = '$email'";

        $user = DB::select($sqlEmail);

        if ($user) {
            return response()->json(['message' => 'Usuario não encontrado!'], 400);
        }

        //atualizar dados do usuario
        $sql = "UPDATE users 
                SET 
                    nome_completo = '$nome_completo',
                    login = '$login',
                    password = '$password',
                    email = '$email',
                    id_cargo = $id_cargo
                WHERE
                    id = $id";

        DB::update($sql);

        return response()->json(['message' => 'Usuario atualizado!'], 200);
    }

    public function index()
    {
        $sql = "SELECT
                    * 
                FROM
                    usuarios";

        $users = DB::select($sql);

        return response()->json($users);
    }
}
