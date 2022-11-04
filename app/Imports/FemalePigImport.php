<?php

namespace App\Imports;

use App\Models\FemalePig;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Carbon\Carbon;

// class FemalePigImport implements ToModel, WithHeadingRow
class FemalePigImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // use Importable;

    // public function model(array $row)
    // {
    //     return new FemalePig([
    //         'id'             => $row['id'],
    //         'individual_num' => $row['individual_num'],
    //         // 'add_day'        => $row['add_day'],
    //         'add_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['add_day'])),
    //         // 'left_day'       => $row['left_day'],
    //         'left_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['left_day'])),
    //         'warn_flag'      => $row['warn_flag'],
    //         'created_at'     => $row['created_at'],
    //         'updated_at'     => $row['updated_at'],
    //         // 'deleted_at'     => $row['deleted_at'],
    //         // 'deleted_at'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['deleted_at'])),
    //         // deleted_atをdatetimeではなく
    //         // 'exist'          => $row['exist'],
    //     ]);
    // }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $femalePig = FemalePig::firstOrCreate([
            'id'             => $row['id'],
            'individual_num' => $row['individual_num'],
            // 'add_day'        => $row['add_day'],
            'add_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['add_day'])),
            // 'left_day'       => $row['left_day'],
            'left_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['left_day'])),
            'warn_flag'      => $row['warn_flag'],
            'created_at'     => $row['created_at'],
            'updated_at'     => $row['updated_at'],
            // 'deleted_at'     => $row['deleted_at'],
            'deleted_at'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['deleted_at'])),
            // 'exist'          => $row['exist'],
        ]);

        if($femalePig->wasRecentlyCreated){
                $deleted_at=Carbon::createFromFormat('Y-m-d H:i:s', $femalePig->deleted_at)->format('Y-m-d');
                if($deleted_at=='1980-01-01'){
                    $femalePig->deleted_at=null;
                    $femalePig->update();
                }
        }
    }

    // public function chunkSize():int{
    //     return 50;
    // }
}
