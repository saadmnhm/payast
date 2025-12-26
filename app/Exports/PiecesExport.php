<?php

namespace App\Exports;

use App\Models\Piece;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PiecesExport implements FromCollection, WithHeadings{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Piece::select(
            'id',
            'name',
            'reference',
            'price',
            'category_id',
            'brand_id',
            'description',
            'stock'
        )->get()->map(function ($piece) {
            return [
                $piece->id,
                $piece->name,
                $piece->reference,
                $piece->price . ' MAD', 
                $piece->category_id,
                $piece->brand_id,
                $piece->description,
                $piece->stock,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Reference',
            'Price',
            'Category ID',
            'Brand ID',
            'Description',
            'Stock'
        ];
    }
    // public function columnFormats(): array
    // {
    //     return[
    //         'D' => '#,##0.00 "MAD"', 
    //     ];
    // }
}
