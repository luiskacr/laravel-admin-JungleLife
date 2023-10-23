<?php

namespace App\Exports;

use App\Traits\ReportsTrait;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CreditReportExport implements FromArray, WithStrictNullComparison,WithHeadings, WithColumnFormatting, ShouldAutoSize
{

    use ReportsTrait;

    public function array(): array
    {
        return $this->getCreditInvoiceReport();
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_CURRENCY_USD,
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function headings(): array
    {
        return [
            __('app.invoice'),
            __('app.date'),
            __('app.money_type'),
            __('app.total'),
            __('app.customer_single')
        ];
    }
}
