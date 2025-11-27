<?php

namespace App\Exports;

use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaboratoriumExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Laboratorium::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'No Antrian',
            'Nama Pasien',
            'Dari',
            'Jenis Bayar',
            'Status',
            'Created At',
            'Updated At'
        ];
    }
}


