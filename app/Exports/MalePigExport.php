<?php

namespace App\Exports;

use App\Models\MalePig;
use Maatwebsite\Excel\Concerns\FromCollection;

class MalePigExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MalePig::all();
    }
}
