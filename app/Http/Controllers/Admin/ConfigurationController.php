<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

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

    }
}
