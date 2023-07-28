<?php

namespace App\Traits;

use App\Mail\ThanksTour;
use App\Models\Configuration;
use App\Models\Timetables;
use App\Models\Tour;
use App\Models\TourClient;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

trait TourTraits
{
    /**
     *  Validate the Create Request Form
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function validateCreateRequest(Request $request):void
    {
        $rules = [
            'date' => 'required|date',
            'time' => 'required|not_in:0',
        ];

        $attributes =[
            'date' => __('app.date'),
            'time' => __('app.timetables'),
        ];

        $this->validate($request, $rules, [], $attributes);
    }

    /**
     *  Validate the Update Request Form
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function validateUpdateRequest(Request $request):void
    {
        $rules = [
            'name' => 'required|min:2|max:100',
            'date' => 'required|date',
            'time' => 'required|not_in:0',
            'tour-state' => 'required|not_in:0',
            'info' => 'max:500',
        ];

        $attributes =[
            'name' => __('app.name'),
            'date' => __('app.date'),
            'time' => __('app.timetables'),
            'tour-state' => __('app.tour_states_singular'),
            'info' => __('app.info_tours'),
        ];

        $this->validate($request, $rules, [], $attributes);
    }

    /**
     * Create a Tour Model in correct Format
     *
     * @param Timetables $timetable
     * @param Carbon $date
     * @param int $userId
     * @param string $info
     * @return void
     * @throws Exception
     */
    public function creatTour(Timetables $timetable, Carbon $date, int $userId, string $info):void
    {
        try{
            $year = $date->year;
            $month = $date->month;
            $day = $date->day;
            $hourStar = Carbon::parse($timetable->start)->hour;
            $hourEnd = Carbon::parse($timetable->end)->hour;

            Tour::create([
                'title' =>  __('app.tour_singular') . ' de ' . $timetable->tourType->name . ' del ' . $date->format('d/m/Y')  . ' a las ' . $timetable->start->format('g:i A'),
                'start' => Carbon::now()->setDate($year,$month,$day)->setTime($hourStar, 0, 0)->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->setDate($year,$month,$day)->setTime($hourEnd, 0, 0)->format('Y-m-d H:i:s'),
                'info' => $info,
                'state' => 1,
                'type' => $timetable->type,
                'user' => $userId
            ]);

        }catch (\Exception $e){

            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:tours:create');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');

            throw new Exception( 'Error to create',0,$e);
        }
    }

    /**
     * Handle the Tour "updated" event and send a thanks email if is required
     *
     * @param Tour $tour
     * @return void
     */
    public function updatingObserver(Tour $tour):void
    {
        try {
            $oldValues = $tour->getOriginal();
            $newValues = $tour->getAttributes();

            if($oldValues['state'] != 2 and $newValues['state']  == 2){

                $configurations = Configuration::all();

                //$configurations[5] is an Automatic send thanks Mail
                if( $configurations[5]->data['value'] or $configurations[5]->data['value'] == 1 ){

                    $clients = TourClient::where('tour', '=' , $newValues['id'])->get();

                    foreach($clients as $client){

                        //$configurations[6]->data['value'][$payment] Verified if this payment has the automatic send thanks Mail
                        if($configurations[6]->data['value'][ strval($client->getInvoice->type)] and $clients->present )
                        {
                            Mail::to( $client->getClient->email )->queue( new ThanksTour($client->getClient->name, $configurations[7]->data['value'] ) );
                        }
                    }
                }

            }
        }catch (\Exception $e){

            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:Auto Thanks Mail');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');
        }
    }

    /**
     * Search for all tours that are still open after closing time to close them.
     *
     * @return int
     */
    public function closeTours():int
    {
        try{
            $config = Configuration::find(3); // Validate if the automatic Option is Enable
            $isActive = $config->data['value'];

            if($isActive){
                $date = Carbon::now('America/Costa_Rica')->format('Y-m-d H:i:s');

                $openTours = Tour::all()
                    ->where("state", "=",1)
                    ->where('end','<', $date);

                foreach ($openTours as $tour){
                    $tour->update([
                        'state' => 2
                    ]);
                }
            }

            return Command::SUCCESS;
        }catch (\Exception $e){

            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:tours:close');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');

            return Command::FAILURE;
        }
    }

    /**
     * Convert a Tour to an Array for a Json response
     *
     * @param Tour $tour
     * @return array
     */
    public function tourToArray(Tour $tour): array
    {
        return [
            'id' => $tour->id,
            'name' => $tour->title,
            'type' =>[
                'id' => $tour->type,
                'name' => $tour->tourType-> name,
            ],
            'start' => Carbon::parse($tour->start)->format('d/m/Y H:i:s'),
            'end' => Carbon::parse($tour->end)->format('d/m/Y H:i:s'),
            'available_space' => $tour->availableSpace(),
        ];
    }

}
