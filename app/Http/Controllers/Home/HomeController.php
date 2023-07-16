<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Customer;
use App\Models\ExchangeRate;
use App\Models\Invoice;
use App\Models\Tour;
use App\Models\TourGuides;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function show():View
    {
        $dateValue = Carbon::now('America/Costa_Rica')->format('Y-m-d');
        $rate = ExchangeRate::where('date', '=', $dateValue)->take(1)->get();
        $config = Configuration::all();


        $values =[
            'tours' => Tour::where('state', '=', 1)
                ->where('start', 'LIKE', '%'.$dateValue.'%')
                ->count(),
            'sell' => $rate->isEmpty()
                ? 0
                : $rate[0]->sell ,
            'buy' => $rate->isEmpty()
                ? 0
                : $rate[0]->buy ,
            'clients' => Customer::all()->count(),
            'message' => $config[4]->data['value'],
            'invoices' => Invoice::where('date','>=',date('Y-m-01') )
                ->where('date','<=',date('Y-m-t') )
                ->where('type','!=',5)
                ->count(),
            'web' => Invoice::where('date','>=',date('Y-m-01') )
                ->where('date','<=',date('Y-m-t') )
                ->where('type','=',5)
                ->count(),
        ];

        return view('admin.home')
            ->with('values',$values);
    }


    public function getTableReport()
    {
        $tours = Tour::where('start','>=',date('Y-m-01') )->where('start','<=',date('Y-m-t') )->get();
        $report= [];

        foreach ($tours as $tour){
            if(!isset($report[$tour->type])){
                $report[$tour->type] =[
                    'name' => $tour->tourType->name,
                    'tour' =>1,
                    'reservations' => $tour->usedSpace(),
                    'available' => $tour->availableSpace(),
                    'guides' => TourGuides::where('tour', '=', $tour->id)->count()
                ];
            }else{
                $report[$tour->type] = [
                    'name' => $report[$tour->type]['name'],
                    'tour' =>$report[$tour->type]['tour'] + 1,
                    'reservations' =>  $report[$tour->type]['reservations'] + $tour->usedSpace(),
                    'available' => $report[$tour->type]['available'] + $tour->availableSpace(),
                    'guides' =>  $report[$tour->type]['guides'] + TourGuides::where('tour', '=', $tour->id)->count()
                ];
            }
        }

        return $report;
    }
}
