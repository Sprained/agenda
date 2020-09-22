<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConselhoController extends Controller
{
    public function insert(Request $request)
    {
        //validação dos dados
        $validate = Validator::make(
            $request->all(),
            [
                'conselho' => 'required|string|min:3'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['message' => 'Dados inseridos com erro!'], 400);
        }

        //body
        $conselho = $request->input('conselho');

        //verificar conselho cadastrado
        $sqlCon = "SELECT
                        * 
                    FROM
                        conselho 
                    WHERE
                        conselho = '$conselho'";

        $conse = DB::select($sqlCon);

        if ($conse) {
            return response()->json(['message', 'Conselho ja cadastrado'], 400);
        }

        //inserir conselho
        $sql = "INSERT INTO 
                    conselho ( conselho )
                VALUES
                    ('$conselho')";

        DB::insert($sql);

        return response()->json(['message' => 'Conselho cadastrado com sucesso!'], 200);
    }
}
