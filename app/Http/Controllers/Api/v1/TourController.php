<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Traits\ApiResponseTrait;
use App\Traits\TourTraits;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourController extends Controller
{
    use ApiResponseTrait, TourTraits;

    /**
     * Response all paginate Tour
     *
     * @return JsonResponse
     */
    public function getAll():JsonResponse
    {
        $rawTours = Tour::where('state', '=' , 1)->paginate(50);
        $tours = [];

        foreach ($rawTours as $tour){

            $tours[] = $this->tourToArray($tour);
        }

        return $this->successResponse(['tours'=> $tours ]);
    }

    /**
     * Get al Tour from a range Dates
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllRangeTours(Request $request):JsonResponse
    {
        try{
            $rawTours = Tour::where('state', '=' , 1)
                ->whereDate('start', '>=', Carbon::parse( $request->get('start') ) )
                ->whereDate('end', '<=', Carbon::parse( $request->get('end') ))
                ->get();

            $tours = [];

            foreach ($rawTours as $tour)
            {
                $tours[] = $this->tourToArray($tour);
            }

            return $this->successResponse(['tours'=> $tours ]);

        }catch (InvalidFormatException $e) {

            return $this->errorResponse($e,'Incorrect date format, the correct one is m/d/Y like ' . Carbon::now()->format('m/d/Y'), 400);

        }catch (\Exception $e){
            return $this->errorResponse($e,'Internal ERROR' );
        }

    }

    /**
     * Show a Specific tour from his id
     *
     * @param  $id
     * @return JsonResponse
     */
    public function show($id):JsonResponse
    {
        try {
//            if (!is_int($id)) {
//                throw new \InvalidArgumentException('Invalid ID format. Please provide a valid integer.');
//            }

            $rawTour = Tour::findOrFail($id);

            if($rawTour->state != 1){
                return $this->errorResponse(new \Exception(), 'Not Found', 404);
            }

            $tour = $this->tourToArray($rawTour);

            return $this->successResponse(['tour'=> $tour ]);

        }catch(ModelNotFoundException $e){

            return $this->errorResponse($e, 'Not Found', 404);

        }catch (\InvalidArgumentException $e) {

            return $this->errorResponse($e, 'Bad Request', 400);

        } catch (\Exception $e){

            return $this->errorResponse($e,'Internal ERROR' );
        }
    }
}
