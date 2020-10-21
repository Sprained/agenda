<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    public function insert(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'tempo_consulta' => 'required|date_format:H:i:s',
                'id_medico' => 'required',
                'semanas' => 'required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['message' => 'Dados informados com erro!'], 400);
        }

        $tempo_consulta = $request->input('tempo_consulta');
        $id_medico = $request->input('id_medico');
        $semanas = $request->input('semanas');

        $sql = "SELECT
                    * 
                FROM
                    medico 
                WHERE
                    id = $id_medico";
        $medico = DB::select($sql);

        if (!$medico) {
            return response()->json(['message' => 'Medico não cadastrado!'], 400);
        }

        $sql = "INSERT INTO 
                    agenda ( tempo_consulta, id_medico )
                VALUES
                    ( '$tempo_consulta', $id_medico )";
        DB::insert($sql);

        $sql = "SELECT
                    id 
                FROM
                    agenda 
                WHERE
                    id_medico = $id_medico";
        $agenda = DB::selectOne($sql);

        foreach ($semanas as $value) {
            $semana = (object) $value;
            $sql = "INSERT INTO 
                        semana_agenda ( id_semana, id_agenda )
                    VALUES
                        ( $semana->id, $agenda->id )";
            DB::insert($sql);
        }

        return response()->json(['message' => 'Agenda cadastrada com sucesso'], 200);
    }

    public function index($id_medico)
    {
        $sql = "SELECT
                    a.id AS agendamento_id,
                    a.data_hora,
                    p.id AS paciente_id,
                    p.nome_completo 
                FROM
                    agendamento AS a
                    INNER JOIN paciente_info AS p ON p.id = a.id_paciente_info 
                WHERE
                    id_medico = $id_medico";
        $agenda = DB::select($sql);

        return response()->json($agenda);
    }
}
