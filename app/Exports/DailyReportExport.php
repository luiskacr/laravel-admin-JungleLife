<?php

namespace App\Exports;

use App\Traits\ReportsTrait;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;



class DailyReportExport implements FromArray, WithStrictNullComparison,WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use ReportsTrait;

    /**
     * Date Value
     *
     * @var string
     */
    private string $date;

    /**
     * Costa Rica Colon Currency Format
     */
    const FORMAT_CURRENCY_COLONES = '₡#,##0.00';

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
     * Return an Array with the Report Information
     *
     * @return array
     */
    public function array(): array
    {
        return $this->getDailyProfitReport($this->date);
    }

    /**
     * Define the Head values
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            __('app.tour_singular'),
            __('app.report_daily_col_total'),
            __('app.report_daily_dol_total'),
            __('app.guides_cost'),
            __('app.reports_total')
        ];
    }

    /**
     * Define the Columns Format
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => self::FORMAT_CURRENCY_COLONES,
            'C' => NumberFormat::FORMAT_CURRENCY_USD,
            'D' => NumberFormat::FORMAT_CURRENCY_USD,
            'E' => NumberFormat::FORMAT_CURRENCY_USD,
        ];
    }

}
