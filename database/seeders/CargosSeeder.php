<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $sql = "INSERT INTO 
                        cargos ( descricao )
                    VALUES
                        ( 'ADMINISTRADOR' ),
                        ( 'ATENDENTE' ),
                        ( 'MEDICO' )";
            
            DB::insert($sql);
        }
    }
}
