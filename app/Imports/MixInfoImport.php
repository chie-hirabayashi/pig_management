<?php

namespace App\Imports;

use App\Models\MixInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Carbon\Carbon;

class MixInfoImport implements OnEachRow, WithHeadingRow
// class MixInfoImport implements ToModel, WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */

    // use Importable;

    // public function model(array $row)
    // {
    //     return new MixInfo([
    //         'id'             => $row['id'],
    //         'female_id'      => $row['female_id'],
    //         'male_first_id'  => $row['male_first_id'],
    //         'male_second_id' => $row['male_second_id'],
    //         'mix_day'        => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mix_day'])),
    //         'recurrence_first_schedule'  => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['recurrence_first_schedule'])),
    //         'recurrence_second_schedule' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['recurrence_second_schedule'])),
    //         'delivery_schedule'          => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['delivery_schedule'])),
    //         'trouble_day'                => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['trouble_day'])),
    //         'trouble_id'                 => $row['trouble_id'],
    //         'born_day'                   => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['born_day'])),
    //         'born_num'                   => $row['born_num'],
    //     ]);
    // }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $mixInfo = MixInfo::firstOrCreate([
            'id'             => $row['id'],
            'female_id'      => $row['female_id'],
            'male_first_id'  => $row['male_first_id'],
            'male_second_id' => $row['male_second_id'],
            'mix_day'        => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mix_day'])),
            'recurrence_first_schedule'  => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['recurrence_first_schedule'])),
            'recurrence_second_schedule' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['recurrence_second_schedule'])),
            'delivery_schedule'          => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['delivery_schedule'])),
            'trouble_day'                => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['trouble_day'])),
            'trouble_id'                 => $row['trouble_id'],
            'born_day'                   => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['born_day'])),
            'born_num'                   => $row['born_num'],
            // 'created_at'                 => $row['created_at'],
            // 'updated_at'                 => $row['updated_at'],
        ]);

        if($mixInfo->wasRecentlyCreated){
                $born_day=Carbon::createFromFormat('Y-m-d H:i:s', $mixInfo->born_day)->format('Y-m-d');
                if($born_day=='1970-01-01'){
                    $mixInfo->born_day=null;
                    $mixInfo->update();
                }
        }
    }
}
