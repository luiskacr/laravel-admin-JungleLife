<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ToursHistoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Guides;
use App\Models\MoneyType;
use App\Models\Tour;
use App\Models\TourClient;
use App\Models\TourGuides;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HistoryController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ToursHistoryDataTable $dataTable
     * @return mixed
     */
    public function index(ToursHistoryDataTable $dataTable):mixed
    {
        return $dataTable->render('admin.historyTour.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id):View
    {
        $tour = Tour::findOrFail($id);

        if($tour->state != 2 )
        {
            $this->errorAbort404();
        }

        $config = Configuration::findOrFail(4);

        return view('admin.historyTour.show')
            ->with('tour',$tour)
            ->with('tourGuides',TourGuides::all()->where('tour','=',$id))
            ->with('guides', Guides::all())
            ->with('clients', TourClient::all()->where('tour','=',$id))
            ->with('account',$tour->GuidesPayment())
            ->with('prefix',$config->data['value'])
            ->with('money',MoneyType::all());
    }


    public function updateTourClient(Request $request,int $id)
    {
        DB::beginTransaction();
        try{

            TourClient::whereId($request->request->get('tourGuides'))->update([
                'guides' => $request->request->getInt('guides'),
                'present'=> $request->request->getBoolean('present'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorJsonResponse($e->getMessage(), __('app.error_delete') );
        }
        return $this->successJsonResponse( ['message' => __('app.success') ] );

    }
}
