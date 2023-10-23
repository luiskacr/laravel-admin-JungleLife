<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CreditReportExport;
use App\Exports\DailyReportExport;
use App\Exports\GuidesReportExport;
use App\Http\Controllers\Controller;
use App\Traits\ReportsTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportsController extends Controller
{

    use ReportsTrait,ResponseTrait;

    /**
     * Display a View.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.reports.index');
    }

    /**
     * Display a Daily Report View.
     *
     * @return View
     */
    public function dailyReportView():View
    {
        return view('admin.reports.daily');
    }

    /**
     * Return a Json with the Daily info report
     *
     * @param string $date
     * @return JsonResponse
     */
    public function getDailyReportValue(string $date):JsonResponse
    {
        return $this->successJsonResponse($this->getDailyProfitReport($date));
    }

    /**
     * Return an Excel Daily Report
     *
     * @param string $date
     * @return BinaryFileResponse
     */
    public function downloadExcelDailyReport(string $date):BinaryFileResponse
    {
        return Excel::download(new DailyReportExport($date) , 'daily_report.xlsx');
    }

    /**
     * Display a Guides Report view
     *
     * @return View
     */
    public function guidesReportView():View
    {
        return view('admin.reports.guides');
    }

    /**
     * Return a Json with the Guides Report
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getGuidesReport(Request $request):JsonResponse
    {
        return $this->successJsonResponse($this->getGuidesTour($request->get('start') , $request->get('end')));
    }

    /**
     * Return an Excel Guides Report File
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadExcelGuidesReport(Request $request):BinaryFileResponse
    {
        return Excel::download(new GuidesReportExport($request->get('start') , $request->get('end')), 'guides_report.xlsx');
    }

    /**
     * Display a Guides Credit reports
     *
     * @return View
     */
    public function creditReportView():View
    {
        return view('admin.reports.credit')
            ->with('credits', $this->getCreditInvoiceReport());
    }

    /**
     * Return an Excel Credit Report File
     *
     * @return BinaryFileResponse
     */
    public function downloadExcelPredictReport():BinaryFileResponse
    {
        return Excel::download(new CreditReportExport(), 'credit_report.xlsx');
    }

    /**
     * Display a Yearly View Report
     *
     * @return View
     */
    public function yearlyReportView():View
    {
        return view('admin.reports.yearly');
    }

    /**
     * Get a report info
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getYearlyReportValue(Request $request):JsonResponse
    {
        return $this->successJsonResponse($this->getYearlyReport($request->get('year') ));
    }

    public function monthlyReportView():View
    {
        return view('admin.reports.monthly');
    }

    public function getMonthlyReportValue(Request $request):JsonResponse
    {
        return $this->successJsonResponse($this->getMonthlyReport($request->get('year'), $request->get('month') ));
    }

}
