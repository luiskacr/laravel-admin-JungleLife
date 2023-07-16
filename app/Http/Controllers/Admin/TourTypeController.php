<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourTypeRequest;
use App\Models\MoneyType;
use App\Models\TourType;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TourTypeController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.tourTypes.index')
            ->with('tourTypes',TourType::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.tourTypes.create')
            ->with('moneyTypes',MoneyType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TourTypeRequest $request
     * @return RedirectResponse
     */
    public function store(TourTypeRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            TourType::create([
                'name'=>$request->request->get('name'),
                'money'=>$request->request->getInt('money'),
                'fee1'=>$request->request->getInt('fee1'),
                'fee2'=>$request->request->get('fee2'),
                'fee3'=>$request->request->get('fee3'),
                'fee4'=>$request->request->get('fee4'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('tour-type.create' , $e->getMessage(), __('app.error_create', ['object' => __('app.tour_type_singular') ]) );
        }
        return $this->successCreateResponse('tour-type.index',__('app.tour_type_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.tourTypes.show')
            ->with('tourType', TourType::findOrFail($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.tourTypes.edit')
            ->with('tourType', TourType::findOrFail($id) )
            ->with('moneyTypes', MoneyType::all() );
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param TourTypeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(TourTypeRequest $request,int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            TourType::whereId($id)->update([
                'name'=>$request->request->get('name'),
                'money'=>$request->request->getInt('money'),
                'fee1'=>$request->request->getInt('fee1'),
                'fee2'=>$request->request->get('fee2'),
                'fee3'=>$request->request->get('fee3'),
                'fee4'=>$request->request->get('fee4'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('tour-type.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.tour_type_singular') ]) );
        }
        return $this->successUpdateResponse('tour-type.index', __('app.tour_type_singular') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id):Response
    {
        DB::beginTransaction();
        try{
            $tourType = TourType::findOrFail($id);
            $tourType->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            if ($e->getCode() === '23000') {
                return $this->errorIntegrityHandleResponse();
            }

            return $this->errorDestroyResponse( $e, __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
