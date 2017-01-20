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

        $plants = Plant::paginate(10);

        $returnPlants = [];

        foreach($plants as $plant)
        {
//            $plant->view_plant = [
//                'href' => 'api/v1/lvl/' . $plant->id,
//                'method' => 'GET'
//            ];
//
//            $plant->name = Plant::botanicalName($plant);

            $tempPlant = [
                'id' => $plant->plant_id,
                'botanical_name' => Plant::botanicalName($plant),
                'common_name' => $plant->common_name,
                'view_plant' => [
                    'href' => url('/') . '/api/v1/lvl/' . $plant->plant_id,
                    'method' => 'GET'
                ]
            ];
            array_push($returnPlants, $tempPlant);
        }

        $response = [
            'msg' => 'Plant List',
            'summary' => [
                'total' => $plants->total(),
                'per_page' => $plants->perPage(),
                'current_page' => $plants->currentPage(),
                'last_page' => $plants->lastPage(),
                'next_page_url' => $plants->nextPageUrl(),
                'prev_page_url' => $plants->previousPageUrl(),
                'from' => $plants->firstItem(),
                'to' => $plants->lastItem()
            ],
            'plants' => $returnPlants
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

        $plant->botanical_name = Plant::botanicalName($plant);

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
