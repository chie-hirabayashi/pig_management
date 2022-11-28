<?php

namespace App\Imports;

use App\Models\BornInfo;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class BornInfoImport implements OnEachRow, WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $bornInfo = BornInfo::firstOrCreate([
            'id' => $row['id'],
            'mix_id' => $row['mix_id'],
            'born_day' => Carbon::instance(
                \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    $row['born_day']
                )
            ),
            'born_num' => $row['born_num'],
        ]);

        if ($bornInfo->wasRecentlyCreated) {
            // born_dayの修正
            $born_day = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $bornInfo->born_day
            )->format('Y-m-d');
            if ($born_day == '1970-01-01') {
                $bornInfo->born_day = null;
                $bornInfo->update();
            }
        }
    }
}
