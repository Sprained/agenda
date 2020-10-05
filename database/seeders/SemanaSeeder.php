<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semanas = ['Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sabado'];

        foreach($semanas as $value){
            $sql = "INSERT INTO 
                        semana ( dia_semana )
                    VALUES
                        ('$value')";

            DB::insert($sql);
        }
    }
}
