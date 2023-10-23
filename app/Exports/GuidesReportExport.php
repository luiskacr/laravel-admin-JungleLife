<?php

namespace App\Exports;

use App\Traits\ReportsTrait;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class GuidesReportExport implements FromArray, WithStrictNullComparison,WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use ReportsTrait;
    /**
     * Date Value
     *
     * @var string
     */
    private string $starDate;

    /**
     * Date Value
     *
     * @var string
     */
    private string $endDate;

    /**
     * @param string $starDate
     * @param string $endDate
     */
    public function __construct(string $starDate, string $endDate)
    {
        $this->starDate = $starDate;
        $this->endDate = $endDate;
    }


    public function array(): array
    {
        return $this->getGuidesForExcel($this->starDate,$this->endDate);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_CURRENCY_USD,
        ];
    }

    public function headings(): array
    {
        return [
            __('app.guide_singular'),
            __('app.tour_singular'),
            __('app.report_guides_commission') ,

        ];
    }


}
