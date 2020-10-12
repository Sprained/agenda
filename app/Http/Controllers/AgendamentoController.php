<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgendamentoController extends Controller
{
    public function insert(Request $request, $id_medico)
    {
        //validação
        $validate = Validator::make(
            $request->all(),
            [
                'nome_completo' => 'string',
                'telefone' => 'int',
                'id_paciente_info' => 'int',
                'data_hora' => 'required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['message' => 'Dados informados com erro!'], 400);
        }

        $nome_completo = $request->input('nome_completo');
        $telefone = $request->input('telefone');
        $id_paciente_info = $request->input('id_paciente_info');
        $data_hora = $request->input('data_hora');

        $dia_semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sabado');
        $semana_num = date('w', strtotime($data_hora));

        $sql = "SELECT
                    s.dia_semana 
                FROM
                    semana_agenda sa
                    INNER JOIN semana s ON s.id = sa.id_semana 
                WHERE
                    sa.id_agenda IN ( SELECT id FROM agenda WHERE id_medico = $id_medico )";

        $semana_medico = DB::select($sql);

        $this->true = false;

        foreach ($semana_medico as $value) {
            $dia = (object) $value;

            if ($dia_semana[$semana_num] == $dia->dia_semana) {
                $this->true = true;
            }
        }

        if (!$this->true) {
            return response()->json(['message' => 'Medico não atende no dia'], 400);
        }

        if (!Helper::feriado($data_hora)) {
            return response()->json(['message' => 'O dia é um feriado!'], 400);
        }

        if (!$id_paciente_info) {
            $sql = "INSERT INTO 
                    paciente_info (nome_completo, telefone)
                VALUES
                    ('$nome_completo', $telefone)";

            DB::insert($sql);

            $sql = "SELECT
                    * 
                FROM
                    paciente_info 
                WHERE
                    nome_completo = '$nome_completo' 
                    AND telefone = $telefone";

            $id_paciente_info = DB::selectOne($sql);
        }

        $sql = "INSERT INTO 
                    agendamento (id_medico, data_hora, id_paciente_info)
                VALUES
                    ($id_medico, '$data_hora', $id_paciente_info->id)";

        DB::insert($sql);

        return response()->json(['message' => 'Consulta marcada com sucesso!'], 200);
    }
}
