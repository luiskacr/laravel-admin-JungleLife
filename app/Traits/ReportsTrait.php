<?php

namespace App\Traits;

use App\Models\Configuration;
use App\Models\Invoice;
use App\Models\Tour;
use App\Models\TourClient;
use App\Models\TourGuides;
use Carbon\Carbon;

trait ReportsTrait
{

    /**
     * Generate an Array with a Daily Tours Profit Report
     *
     * @param String $date
     * @return array
     */
    public function  getDailyProfitReport(String $date):array
    {
        $report =[];
        $tours = Tour::whereDate('start' ,'like', Carbon::parse($date)->format('Y-m-d'))->where('state', '=',2)->get();

        foreach ($tours as $tour)
        {
            $bookings = TourClient::where('tour', '=' , $tour->id)->get();
            $guideFees = 0;
            $colTotal = 0;
            $dolTotal = 0;
            $totalConvert=0;

            foreach($bookings as $booking)
            {
                $booking->getInvoice->money == 1
                    ? $colTotal = $colTotal + $booking->getInvoice->total
                    : $dolTotal = $dolTotal + $booking->getInvoice->total;

                $booking->getInvoice->money == 1
                    ? $totalConvert = $totalConvert + ( $booking->getInvoice->total / $booking->getInvoice->getExchange->sell )
                    : $totalConvert = $totalConvert;
            }

            $guides = $tour->GuidesPayment();
            foreach ($guides as $guide){
                $guideFees = $guideFees + $tour->findGuideFee($guide['bookings_apply']);
            }

            $report[] =[
                __('app.tour_singular') => $tour->title,
                __('app.report_daily_col_total') =>$colTotal,
                __('app.report_daily_dol_total') => $dolTotal,
                __('app.guides_cost') => $guideFees,
                __('app.reports_total') => ($totalConvert + $dolTotal) - $guideFees
            ];
        }

        return $report;
    }

    /**
     * Get the Guides and all Tour where they have a commission
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getGuidesTour(string $startDate, string $endDate):array
    {
        $tours = Tour::whereDate('start', '>=', Carbon::parse($startDate)->format('Y-m-d') )
            ->whereDate('start', '<=', Carbon::parse($endDate)->format('Y-m-d') )
            ->where('state', '=',2)
            ->get();

        $report = [];

        foreach ($tours as $tour){
            $payments = $tour->GuidesPayment();

            foreach ($payments as $payment){

                if(!isset($report['guide'])){
                    $report[$payment['guide']][$tour->title] =[
                        'payment' => $tour->findGuideFee( $payment['bookings_apply'] )
                    ];
                }else{
                    $report[$payment['guide']][$tour->title] =[
                        'payment' => $payment['guide']['payment'] + $tour->findGuideFee( $payment['bookings_apply'] )
                    ];
                }
            }
        }

        return $report;
    }

    /**
     * Generate an array from a getGuidesTour for an Excel Format
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getGuidesForExcel(string $startDate, string $endDate):array
    {
        $finalReport= [];
        $reports = $this->getGuidesTour($startDate, $endDate);

        foreach ($reports as $key => $report){
           if($key != "Guia no asignado"){

               foreach ($report as $tour => $payment){
                   $finalReport[] = [
                       __('app.guide_singular') => $key,
                       __('app.tour_singular') => $tour,
                       __('app.report_guides_commission') => $payment['payment']
                   ];
               }
           }
        }
        return $finalReport;
    }

    /**
     * Generate an array with Credit invoice
     *
     * @return array
     */
    public function getCreditInvoiceReport():array
    {
        $report=[];
        $invoices = Invoice::where('state' , '=' , 1 )->get();
        $prefix = Configuration::findOrFail(4);

        foreach ($invoices as $invoice){
            $report[]=[
                __('app.invoice')  => $prefix->data['value'] .$invoice->id,
                __('app.date') =>  Carbon::parse($invoice->date)->format('d/m/Y'),
                __('app.money_type') => $invoice->getMoney->name,
                __('app.total') => $invoice->getMoney->symbol. $invoice->total,
                __('app.customer_single') => $invoice->getClient->name,
            ];
        }

        return $report;
    }

    /**
     * Generate a Yearly report with Profit,Cost amd Total.
     *
     * @param string $year
     * @return array
     */
    public function getYearlyReport(string $year):array
    {
        $report=[];

        for ($i =1; $i<= 12; $i++ ){
            $tours = Tour::whereBetween('start',[Carbon::now()->startOfMonth()->month($i)->year($year),
                Carbon::now()->endOfMonth()->month($i)->year($year)])
                ->where('state' , '=' , 2 )->get();

            $total = 0;
            $profit = 0;
            $cost = 0;
            foreach ($tours as $tour){
                $tourGuides = TourClient::where('tour','=', $tour->id)->get();

                foreach ($tourGuides as $tourGuide){
                    $invoiceTotal = $tourGuide->getInvoice->money == 1
                        ? round(($tourGuide->getInvoice->total / $tourGuide->getInvoice->getExchange->buy),2)
                        : $tourGuide->getInvoice->total;
                    $total = $total + $invoiceTotal;
                }

                $guides = $tour->GuidesPayment();
                foreach ($guides as $guide){
                    $cost = $cost + $tour->findGuideFee($guide['bookings_apply']);
                }
            }

            $profit = $profit + ($total - $cost);

            $report[$i] = [
                'total'=> $total,
                'cost' => $cost,
                'profit' => $profit
            ];

        }

        return $report;
    }

    public function getMonthlyReport($year, $month):array
    {
        $report = [];

        $tours = Tour::whereBetween('end',[Carbon::now()->startOfMonth()->month($month)->year($year),
            Carbon::now()->endOfMonth()->month($month)->year($year)])
            ->where('state','=','2')->get();

        foreach ($tours as $tour){
            $bookings = 0;
            $royalties = 0;
            $total = 0;
            $cost =0;
            $profit = 0;

            $tourClients = TourClient::where('tour', '=',$tour->id)->get();

            foreach ($tourClients as $tourClient){
                $bookings = $bookings + $tourClient->bookings;
                $royalties = $royalties + $tourClient->royalties;
                $total = $total+ $tourClient->getInvoice->money == 1
                    ? round($tourClient->getInvoice->total / $tourClient->getInvoice->getExchange->buy,2)
                    : $tourClient->getInvoice->total;
            }

            $guides = $tour->GuidesPayment();
            foreach ($guides as $guide){
                $cost = $cost + $tour->findGuideFee($guide['bookings_apply']);
            }

            $profit = $profit + round($total - $cost , 2);

            if(!isset($report[$tour->type])){

                $report[$tour->type] = [
                    'type' => $tour->tourType->name,
                    'booking' => $bookings,
                    'total' => $total,
                    'cost' => $cost,
                    'profit' => $profit
                ];

            }else{
                $report[$tour->type] = [
                    'type' => $tour->tourType->name,
                    'booking' => $report[$tour->type]['booking'] + $bookings,
                    'total' => $report[$tour->type]['total'] + $total,
                    'cost' => $report[$tour->type]['cost'] + $cost,
                    'profit' =>  $report[$tour->type]['profit'] + $profit
                ];

            }
        }

        return $report;
    }

}
