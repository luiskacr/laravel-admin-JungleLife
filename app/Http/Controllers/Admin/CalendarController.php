<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    /**
     * Display a Calendar
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
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
                        'start' =>  $event->start,
                        'end' =>  $event->end,
                        'backgroundColor' => $event->state == 1 ? "#378006" : "#696cff",
                        'borderColor' => $event->state == 1 ? "#378006" : "#696cff",
                        'color' => $event->state == 1 ? "#378006" : "#696cff",
                        'className' => $event->state == 1 ? "event-open" : "event-close",
                    ];
                }
                return response()->json($data);
            }

            return response()->json($events);
        }catch (\Exception $e){

            app()->hasDebugModeEnabled() ? $message = $e->getMessage() : $message = __('app.error_delete') ;

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

        return response()->json([
            'title' => $tour->title,
            'date'=>  Carbon::parse($tour->start)->format('d/m/Y') ,
            'start' => Carbon::parse($tour->start)->format('g:i A') ,
            'end' => Carbon::parse($tour->end)->format('g:i A') ,
            'info' => $tour->info,
            'state' => $tour->tourState->name,
            'type' => $tour->tourType->name,
            'user' => $tour->getUser->name,
            'guides' => 0,
            'clients' => 0,
            'route' => route('tours.show',$id)
        ],200);
    }

}
