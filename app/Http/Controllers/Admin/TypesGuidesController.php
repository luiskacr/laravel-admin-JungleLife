<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeGuideRequest;
use App\Models\GuidesType;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TypesGuidesController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.typeGuides.index')
            ->with('typesGuides', GuidesType::all() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.typeGuides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TypeGuideRequest $request
     * @return RedirectResponse
     */
    public function store(TypeGuideRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            GuidesType::create([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('type-guides.create' , $e->getMessage(), __('app.error_create', ['object' => __('app.type_guides_singular') ]) );
        }
        return $this->successCreateResponse('type-guides.index',__('app.type_guides_singular'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.typeGuides.show')
            ->with('typesGuide',GuidesType::findOrFail($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.typeGuides.edit')
            ->with('typesGuide', GuidesType::findOrFail($id) );
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param TypeGuideRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(TypeGuideRequest $request,int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            GuidesType::whereId($id)->update([
                'name'=>$request->request->get('name'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB:DB::rollback();

            return $this->errorResponse('type-guides.edit' , $e->getMessage(), __('app.error_update', ['object' => __('app.type_guides_singular') ]) );
        }
        return $this->successUpdateResponse('type-guides.index', __('app.type_guides_singular') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id):Response
    {
        DB::beginTransaction();
        try{
            $clientType = GuidesType::findOrFail($id);
            $clientType->delete();

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
