<?php

namespace App\Exports;

use App\Models\Absent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Absent::whereNull('deleted_at')->select('store_name', 'spg_name', 'date', 'time', 'type', 'latt', 'long', 'user_login')->get();
    }
    public function headings(): array
    {
        return [
            'Nama Toko',
            'Nama SPG',
            'Tanggal',
            'Waktu',
            'Tipe',
            'Latitude',
            'Longitude',
            'Login User'
        ];
        // return $this->collection()->first()->keys()->toArray();
    }
}
