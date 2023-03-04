<?php

namespace App\Exports;

use App\Models\MalePig;
use Maatwebsite\Excel\Concerns\FromCollection;

class MalePigSourceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MalePig::withTrashed()->get();
    }
}
