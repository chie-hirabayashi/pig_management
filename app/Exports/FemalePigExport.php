<?php

namespace App\Exports;

use App\Models\FemalePig;
use Maatwebsite\Excel\Concerns\FromCollection;

class FemalePigExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FemalePig::all();
    }
}
