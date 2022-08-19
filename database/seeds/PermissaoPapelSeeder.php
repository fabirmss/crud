<?php

use Illuminate\Database\Seeder;

class PermissaoPapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entities\Papel::find(1)->permissoes()->sync(
            [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
            ]
        );

        \App\Entities\Papel::find(2)->permissoes()->sync(
            [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
            ]
        );

        \App\Entities\Papel::find(3)->permissoes()->sync(
            [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
            ]
        );

        \App\Entities\Papel::find(4)->permissoes()->sync(
            [
                8,
            ]
        );
    }
}
