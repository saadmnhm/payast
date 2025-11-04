<?php
namespace App\Exports;

use App\Models\Devis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DevisExport implements FromCollection, WithHeadings
{
    /**
     * Return the collection of data to export.
     */
    public function collection()
    {
        return Devis::select('first_name', 'last_name', 'city', 'travaux','phone', 'created_at')->get();
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Adresse',
            'Travaux',
            'phone',
            'Date',
        ];
    }
}