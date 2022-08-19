<?php

use Illuminate\Database\Seeder;

class PermissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::connection('mysql')
                                      ->table('permissoes')->insert([
                // USUÁRIOS
                [
                    'slug' => 'can-access-usuarios',
                    'nome' => 'Ver os usuários',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-create-usuarios',
                    'nome' => 'Criar usuários',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-edit-usuarios',
                    'nome' => 'Editar usuários',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-delete-usuarios',
                    'nome' => 'Deletar usuários',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],

                // PERMISSÕES
                [
                    'slug' => 'can-access-permissoes',
                    'nome' => 'Ver permissões',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-create-permissoes',
                    'nome' => 'Criar permissões',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-edit-permissoes',
                    'nome' => 'Editar permissões',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-delete-permissoes',
                    'nome' => 'Deletar permissões',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],

                // PAPÉIS
                [
                    'slug' => 'can-access-papeis',
                    'nome' => 'Ver papéis',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-create-papeis',
                    'nome' => 'Criar papéis',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-edit-papeis',
                    'nome' => 'Editar papéis',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'slug' => 'can-delete-papeis',
                    'nome' => 'Deletar papéis',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],[
                    'slug' => 'can-access-coleta',
                    'nome' => 'Acessar Coleta',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],[
                    'slug' => 'can-access-sistema-admin',
                    'nome' => 'Acessar Sistema Admin',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],[
                    'slug' => 'can-access-gerenciar-cadastros',
                    'nome' => 'Gerenciar Cadastros Sistema Admin',
                    'hash' => md5(uniqid(mt_rand(), true)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
            ]);
    }
}
