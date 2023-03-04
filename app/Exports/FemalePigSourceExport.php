<?php

namespace App\Exports;

use App\Models\FemalePig;
use Maatwebsite\Excel\Concerns\FromCollection;

class FemalePigSourceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FemalePig::withTrashed()->get();
    }
}
