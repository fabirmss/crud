<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissoesSeeder::class);
        $this->call(PapeisSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PermissaoPapelSeeder::class);
        
    }
}
