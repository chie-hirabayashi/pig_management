<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            // ['place_num' => 1, 'category' => 1,],
            ['place_num' => 2, 'category' => 1,],
            ['place_num' => 3, 'category' => 1,],
            ['place_num' => 4, 'category' => 1,],
            ['place_num' => 5, 'category' => 1,],
            ['place_num' => 6, 'category' => 1,],
            ['place_num' => 7, 'category' => 1,],
            ['place_num' => 8, 'category' => 1,],
            ['place_num' => 9, 'category' => 1,],
            ['place_num' => 10, 'category' => 1,],
            ['place_num' => 11, 'category' => 1,],
            ['place_num' => 12, 'category' => 1,],
            ['place_num' => 13, 'category' => 1,],
            ['place_num' => 14, 'category' => 1,],
            ['place_num' => 15, 'category' => 1,],
            ['place_num' => 16, 'category' => 1,],
            ['place_num' => 17, 'category' => 1,],
            ['place_num' => 18, 'category' => 1,],
            ['place_num' => 19, 'category' => 1,],
            ['place_num' => 20, 'category' => 1,],
            ['place_num' => 21, 'category' => 1,],
            ['place_num' => 22, 'category' => 1,],
            ['place_num' => 23, 'category' => 1,],
            ['place_num' => 24, 'category' => 1,],
            ['place_num' => 25, 'category' => 1,],
            ['place_num' => 26, 'category' => 1,],
            ['place_num' => 27, 'category' => 1,],
            ['place_num' => 28, 'category' => 1,],
            ['place_num' => 29, 'category' => 1,],
            ['place_num' => 30, 'category' => 1,],
            ['place_num' => 31, 'category' => 1,],
            ['place_num' => 32, 'category' => 1,],
            ['place_num' => 33, 'category' => 1,],
            ['place_num' => 34, 'category' => 1,],
            ['place_num' => 35, 'category' => 1,],
            ['place_num' => 36, 'category' => 1,],
            ['place_num' => 37, 'category' => 1,],
            ['place_num' => 38, 'category' => 1,],
            ['place_num' => 39, 'category' => 1,],
            ['place_num' => 40, 'category' => 1,],
            ['place_num' => 41, 'category' => 1,],
            ['place_num' => 42, 'category' => 1,],
            ['place_num' => 43, 'category' => 1,],
            ['place_num' => 44, 'category' => 1,],
            ['place_num' => 45, 'category' => 1,],
            ['place_num' => 46, 'category' => 1,],
            ['place_num' => 47, 'category' => 1,],
            ['place_num' => 48, 'category' => 1,],
            ['place_num' => 49, 'category' => 1,],
            ['place_num' => 50, 'category' => 1,],
            ['place_num' => 51, 'category' => 1,],
            ['place_num' => 52, 'category' => 1,],
            ['place_num' => 53, 'category' => 1,],
            ['place_num' => 54, 'category' => 1,],
            ['place_num' => 55, 'category' => 1,],
            ['place_num' => 56, 'category' => 1,],
            ['place_num' => 57, 'category' => 1,],
            ['place_num' => 58, 'category' => 1,],
            ['place_num' => 59, 'category' => 1,],
            ['place_num' => 60, 'category' => 1,],
            ['place_num' => 'B1', 'category' => 2,],
            ['place_num' => 'B2', 'category' => 2,],
            ['place_num' => 'B3', 'category' => 2,],
            ['place_num' => 'B4', 'category' => 2,],
            ['place_num' => 'B5', 'category' => 2,],
            ['place_num' => 'B6', 'category' => 2,],
            ['place_num' => 'B7', 'category' => 2,],
            ['place_num' => 'B8', 'category' => 2,],
            ['place_num' => 'B9', 'category' => 2,],
            ['place_num' => 'B10', 'category' => 2,],
            ['place_num' => 'B11', 'category' => 2,],
            ['place_num' => 'B12', 'category' => 2,],
            ['place_num' => 'B13', 'category' => 2,],
            ['place_num' => 'B14', 'category' => 2,],
            ['place_num' => 'B15', 'category' => 2,],
            ['place_num' => 'B16', 'category' => 2,],
            ['place_num' => 'B17', 'category' => 2,],
            ['place_num' => 'B18', 'category' => 2,],
            ['place_num' => 'B19', 'category' => 2,],
            ['place_num' => 'B20', 'category' => 2,],
        ];
        DB::table('places')->insert($param);
    }
}
