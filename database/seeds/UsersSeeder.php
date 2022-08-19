<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::connection('mysql')
                                      ->table('users')->insert([
                [
                    'name' => 'Administrador',
                    'email' => 'adm@gmail.com',
                    'email_verified_at' => \Carbon\Carbon::now(),
                    'password' => bcrypt('123456'),
                    'papel_id' => 1,
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
            ]);
    }
}
