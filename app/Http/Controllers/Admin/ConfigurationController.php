<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $configurations = Configuration::all();

        return view('admin.configuration.index')->with('configurations',$configurations);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $values = $request->all();

            $count = 1;
            foreach ($values as $value)
            {
                $config = Configuration::findOrFail($count);
                $config->data = [
                    'value' => $value
                ];
                $config->save();
                $count ++;
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            return response($e->getMessage(), 500);
        }
        return response()->json([
            'result' => 'ok'
        ],200);
    }
}
