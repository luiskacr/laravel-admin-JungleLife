<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Tour;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApprovalController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.approval.index')
            ->with('approvals', Approval::orderBy('created_at', 'desc')->limit(50)->get() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create():View
    {
        return view('admin.approval.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse
    {
        DB::beginTransaction();
        try{
            $tour = Tour::findOrFail($request->get('tour'));
            $message = '';

            $data = [
                'old' => $tour->originalSpaceValue(),
                'new' => $request->get('new'),
                'user' => Auth::user()->id,
                'tour' => $request->get('tour'),
            ];

            if (Auth::user()->hasRole('Administrador')) {
                $data['reviewer'] = Auth::user()->id;
                $data['state'] = 4;

                Approval::create($data);

                $message = __('app.approve_msg1');
            } else {
                $data['reviewer'] = null;
                $data['state'] = 1;

                $approval = Approval::create($data);
                $approval->sendAdminNotification();

                $message = __('app.approve_msg2');
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return response()->json(['message'=> $this->errorMessage($e->getMessage(), __('app.error_delete') )  ], 500);
        }
        return response()->json(['message'=> $message ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id):View
    {
        $approval = Approval::findOrFail($id);

        return view('admin.approval.edit')
            ->with('approval', $approval )
            ->with('spaces', $this->getTourSpacesValuesId($approval->tour) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int  $id):JsonResponse
    {
        DB::beginTransaction();
        try {

            Approval::whereId($id)->update([
                'state'=> $request->request->getBoolean('state') ? 3 : 2,
                'reviewer' => Auth::user()->id
            ]);

            $message = __('app.approve_msg3');

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            return response()->json(['message'=> $this->errorMessage($e->getMessage(), __('app.error_delete') )  ], 500);
        }
        return response()->json(['message'=> $message ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approval $approval)
    {
        //
    }

    /**
     * Response with the Tour spaces values.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTourSpacesValues(Request $request): JsonResponse
    {
        $tour = Tour::findOrFail($request->get('tour'));

        return response()->json([
            'booking' => $tour->usedSpace(),
            'original' => $tour->originalSpaceValue(),
            'old_total' => $tour->availableSpace(),
        ]);
    }

    /**
     * Response with the Tour spaces values.
     *
     * @param int $id
     * @return array
     */
    public function getTourSpacesValuesId(int $id): array
    {
        $tour = Tour::findOrFail($id);

        return [
            'booking' => $tour->usedSpace(),
            'original' => $tour->originalSpaceValue(),
            'old_total' => $tour->availableSpace(),
        ];
    }
}
