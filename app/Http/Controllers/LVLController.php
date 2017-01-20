<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plant;

class LVLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $plants = Plant::all();

        foreach($plants as $plant)
        {
            $plant->view_plant = [
                'href' => 'api/v1/lvl/' . $plant->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'Plant List',
            'plants' => $plants
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plant = Plant::where('plant_id', $id)->firstOrFail();
        $plant->view_plants = [
            'href' => 'api/v1/lvl',
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Plant Information',
            'plant' => $plant
        ];

        return response()->json($response, 200);
    }

}
