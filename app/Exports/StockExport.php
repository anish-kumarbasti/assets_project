<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StockExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'Asset Category',
            'Asset Name',
            'Brand Name',
            'Brand Model Name',
            'Product Name',
            'Serial Number',
            'License Number',
            'Quantity',
            'Asset Code',
            'Attribute Name',
            'Attribute Value',
            'Location Name',
            'SubLocation Name',
            'Host Name',
            'Configuration',
            'Specification',
            'Supplier ID',
            'Supplier Name',
            'Price',
            'Warranty Date',
            'Expiry Date',
        ];
    }
    public function map($row): array
    {
        return [];
    }
    public function columnFormats(): array
    {
        return [
            'W' => 'dd-mm-yyyy', 
            'X' => 'dd-mm-yyyy', 
        ];
    }
}
