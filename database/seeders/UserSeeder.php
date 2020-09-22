<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('adm@123');

        $sql = "INSERT INTO 
                    usuarios ( nome_completo, login, password, email, id_cargo )
                VALUES
                    ( 'adm', 'adm', '$password', 'adm@email.com', 1 )";

        DB::insert($sql);
    }
}
