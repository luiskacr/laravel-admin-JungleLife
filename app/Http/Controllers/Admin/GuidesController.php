<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuideRequest;
use App\Models\Guides;
use App\Models\GuidesType;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PhpParser\Builder;

class GuidesController extends Controller
{
    use ResponseTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('role:Administrador')->only('destroy');
        $this->middleware('role:Administrador,Operador')->only(['create','store','edit','update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index():View
    {
        return view('admin.guide.index')
            ->with('guides', Guides::all() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.guide.create')
            ->with('typeGuides', GuidesType::all() );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GuideRequest $request
     * @return RedirectResponse
     */
    public function store(GuideRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try{
            Guides::create([
                'name' => $request->request->get('name') ,
                'lastName' => $request->request->get('lastName'),
                'type' => $request->request->getInt('type'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return $this->errorResponse('guides.create', $e->getMessage(),  __('app.error_create', ['object' => __('app.guide_singular') ]) );
        }
        return $this->successCreateResponse('guides.index',__('app.guide_singular') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id):View
    {
        return view('admin.guide.show')
            ->with('guide', Guides::findOrFail($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id):View
    {
        return view('admin.guide.edit')
            ->with('guide', Guides::findOrFail($id) )
            ->with('typeGuides',GuidesType::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GuideRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(GuideRequest $request,int $id):RedirectResponse
    {
        DB::beginTransaction();
        try{
            Guides::whereId($id)->update([
                'name' => $request->request->get('name') ,
                'lastName' => $request->request->get('lastName'),
                'type' => $request->request->getInt('type'),
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return $this->errorResponse('guides.edit', $e->getMessage(),  __('app.error_update', ['object' => __('app.guide_singular') ]) );
        }
        return $this->successUpdateResponse('guides.index', __('app.guide_singular') );
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
            $guide = Guides::findOrFail($id);
            $guide->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            if ($e->getCode() === '23000') {
                return $this->errorIntegrityHandleResponse();
            }

            return $this->errorDestroyResponse( $e , __('app.error_delete'), 500 );
        }
        return $this->successDestroyResponse(__('app.success'));
    }
}
