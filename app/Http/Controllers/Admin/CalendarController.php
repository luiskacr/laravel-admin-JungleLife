<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourClient;
use App\Models\TourGuides;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a View with the Calendar
     *
     * @return View
     */
    public function show(): View
    {
        return view('admin.calendar.show');
    }

    /**
     * Response a Json with the events to the calendar
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function getTours(Request $request)
    {
        try{
            $events = Tour::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get();
            $data=[];

            if($events != null){
                foreach ($events as $event){
                    $data[]=[
                        'id'=>  $event->id,
                        'title' =>  $event->title,
                        'start' =>  Carbon::parse($event->start)->format('Y-m-d H:i:s'),
                        'end' =>  Carbon::parse($event->end)->format('Y-m-d H:i:s'),
                        'backgroundColor' => $event->state == 1 ? "#378006" : "#808080;",
                        'borderColor' => $event->state == 1 ? "#378006" : "#808080;",
                        'color' => $event->state == 1 ? "#378006" : "#808080;",
                        'className' => $event->state == 1 ? "event-open" : "event-close",
                    ];
                }
                return response()->json($data);
            }

            return response()->json($events);
        }catch (\Exception $e){

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete');

            return response($message,500);
        }
    }


    /**
     * Return a specify value from a Tour
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfoTour($id)
    {
        $tour = Tour::findOrFail($id);
        $tourGuides = TourGuides::where('tour','=',$id)->get();
        $tourClients = TourClient::where('tour','=',$id)->get();

        return response()->json([
            'title' => $tour->title,
            'date'=>  Carbon::parse($tour->start)->format('d/m/Y') ,
            'start' => Carbon::parse($tour->start)->format('g:i A') ,
            'end' => Carbon::parse($tour->end)->format('g:i A') ,
            'info' => $tour->info,
            'state' => $tour->tourState->name,
            'type' => $tour->tourType->name,
            'user' => $tour->getUser->name,
            'guides' => $tourGuides->count(),
            'clients' => $tourClients->count(),
            'route' => $tour->state == 1
                ? route('tours.show',$id)
                : route('tour-history.show',$id)
        ],200);
    }

}
