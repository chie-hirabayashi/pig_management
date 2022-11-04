<?php

namespace App\Imports;

use App\Models\MalePig;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Carbon\Carbon;

class MalePigImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new MalePig([
    //         //
    //     ]);
    // }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $femalePig = MalePig::firstOrCreate([
            'id'             => $row['id'],
            'individual_num' => $row['individual_num'],
            'add_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['add_day'])),
            'left_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['left_day'])),
            'warn_flag'      => $row['warn_flag'],
            'created_at'     => $row['created_at'],
            'updated_at'     => $row['updated_at'],
            'deleted_at'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['deleted_at'])),
        ]);

        if($femalePig->wasRecentlyCreated){
                $deleted_at=Carbon::createFromFormat('Y-m-d H:i:s', $femalePig->deleted_at)->format('Y-m-d');
                if($deleted_at=='1980-01-01'){
                    $femalePig->deleted_at=null;
                    $femalePig->update();
                }
        }
    }
}
