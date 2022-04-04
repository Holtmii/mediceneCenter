<?php

namespace App\Exports;

use App\Models\Vactination;
use Maatwebsite\Excel\Concerns\FromCollection;

class VacExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vactination::get();
    }
}
