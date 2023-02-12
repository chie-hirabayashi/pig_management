<?php

namespace App\Imports;

use App\Models\MixInfo;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class MixInfoImport implements OnEachRow, WithHeadingRow
{
    // class MixInfoImport implements ToModel, WithHeadingRow
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $mixInfo = MixInfo::firstOrCreate([
            'id' => $row['id'],
            'female_id' => $row['female_id'],
            'first_male_id' => $row['first_male_id'],
            'second_male_id' => $row['second_male_id'],
            'mix_day' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['mix_day']
                )
            ),
            'first_recurrence_schedule' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['first_recurrence_schedule']
                )
            ),
            'second_recurrence_schedule' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['second_recurrence_schedule']
                )
            ),
            'delivery_schedule' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['delivery_schedule']
                )
            ),
            'trouble_day' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['trouble_day']
                )
            ),
            'trouble_id' => $row['trouble_id'],
            'born_day' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['born_day']
                )
            ),
            'born_num' => $row['born_num'],
            'stillbirth_num' => $row['stillbirth_num'],
            'weaning_day' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['weaning_day']
                )
            ),
            'weaning_num' => $row['weaning_num'],
        ]);

        if ($mixInfo->wasRecentlyCreated) {
            // trouble_dayの修正
            $trouble_day = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $mixInfo->trouble_day
            )->format('Y-m-d');
            if ($trouble_day == '1970-01-01') {
                $mixInfo->trouble_day = null;
                $mixInfo->update();
            }
            // born_dayの修正
            $born_day = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $mixInfo->born_day
            )->format('Y-m-d');
            if ($born_day == '1970-01-01') {
                $mixInfo->born_day = null;
                $mixInfo->update();
            }
            // weaning_dayの修正
            $weaning_day = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $mixInfo->weaning_day
            )->format('Y-m-d');
            if ($weaning_day == '1970-01-01') {
                $mixInfo->weaning_day = null;
                $mixInfo->update();
            }
        }
    }

    // use Importable;

    // public function model(array $row)
    // {
    //     return new MixInfo([
    //         'id'             => $row['id'],
    //         'female_id'      => $row['female_id'],
    //         'first_male_id'  => $row['first_male_id'],
    //         'second_male_id' => $row['second_male_id'],
    //         'mix_day'        => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mix_day'])),
    //         'first_recurrence_schedule'  => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['first_recurrence_schedule'])),
    //         'second_recurrence_schedule' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['second_recurrence_schedule'])),
    //         'delivery_schedule'          => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['delivery_schedule'])),
    //         'trouble_day'                => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['trouble_day'])),
    //         'trouble_id'                 => $row['trouble_id'],
    //         'born_day'                   => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['born_day'])),
    //         'born_num'                   => $row['born_num'],
    //     ]);
    // }
}
