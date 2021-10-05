<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            [
                'name' => 'Wolf'
            ],
            [
                'name' => 'Hare'
            ]
        ];
        DB::table('types')->insert($type);
    }
}
