<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TroubleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            [
                'trouble_name' => '異常なし',
            ],
            [
                'trouble_name' => '再発',
            ],
            [
                'trouble_name' => '流産',
            ],
        ];
        DB::table('trouble_categories')->insert($param);
    }
}
