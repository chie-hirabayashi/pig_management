<?php

namespace App\Exports;

use App\Models\MixInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

class MixInfoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MixInfo::all();
    }
}
