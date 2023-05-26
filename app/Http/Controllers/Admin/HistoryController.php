<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\Guides;
use App\Models\GuidesType;
use App\Models\Tour;
use App\Models\TourClient;
use App\Models\TourGuides;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tours =Tour::where('state' ,'=','2')
            ->orderBy('end', 'asc')
            ->get();

        return view('admin.historyTour.index')
            ->with('tours',$tours);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $tour = Tour::findOrFail($id);

        if($tour->state != 2 ){
            return redirect()->route('tour-history.index')
                ->with('error',__('app.error_not_found',['object' => __('app.tour_singular') ] ));
        }

        $tour_has_guides = TourGuides::all()->where('tour','=',$id);
        $guides = Guides::all();
        $typeGuides = GuidesType::all();
        $clientTypes = ClientType::all();
        $tour_has_clients = TourClient::all()->where('tour','=',$id);

        return view('admin.historyTour.show')
            ->with('tour',$tour)
            ->with('tourGuides',$tour_has_guides)
            ->with('guides',$guides)
            ->with('typeGuides',$typeGuides)
            ->with('clients',$tour_has_clients)
            ->with('clientTypes',$clientTypes);
    }
}
