<?php

use Illuminate\Database\Seeder;

class PapeisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::connection('mysql')
                                      ->table('papeis')->insert([
                [
                    'slug' =>'super-admin',
                    'nome' =>'Super Admin',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' =>'admin',
                    'nome' =>'Admin',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now()
                ],
            
                [
                    'slug' =>'administracao',
                    'nome' =>'Administração',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now()
                ],
            ]);
    }
}
