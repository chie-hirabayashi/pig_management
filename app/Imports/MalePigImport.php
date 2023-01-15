<?php

namespace App\Imports;

use App\Models\MalePig;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Carbon\Carbon;

class MalePigImport implements OnEachRow, WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $malePig = MalePig::firstOrCreate([
            'id'             => $row['id'],
            'individual_num' => $row['individual_num'],
            'add_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['add_day'])),
            'left_day'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['left_day'])),
            // 'warn_flag'      => $row['warn_flag'],
            'deleted_at'=>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['deleted_at'])),
        ]);

        if($malePig->wasRecentlyCreated){
            // left_dayの修正
            $left_day=Carbon::createFromFormat('Y-m-d H:i:s', $malePig->left_day)->format('Y-m-d');
            if($left_day=='1970-01-01'){
                $malePig->left_day=null;
                $malePig->update();
            }
            // deleted_atの修正
            $deleted_at=Carbon::createFromFormat('Y-m-d H:i:s', $malePig->deleted_at)->format('Y-m-d');
            if($deleted_at=='1980-01-01'){
                $malePig->deleted_at=null;
                $malePig->update();
            }
        }
    }
}
