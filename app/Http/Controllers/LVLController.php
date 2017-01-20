<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plant;
use App\INFX;

class LVLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $response = [ 'msg' => 'Plant List'];

        if (!INFX::IsNullOrEmptyString($request->input('all')) && (strtolower($request->input('all')) != "false")) {
            $plants = Plant::all();
        } else {
            $perPage = INFX::perPage();
            if(!INFX::IsNullOrEmptyString($request->input('per_page'))) $perPage = $request->input('per_page');

            $plants = Plant::paginate($perPage);

            $next_page = $plants->nextPageUrl();
            $prev_page = $plants->previousPageUrl();

            if ($perPage != INFX::perPage() && !INFX::IsNullOrEmptyString($next_page)) $next_page .= "&per_page=" . $perPage;
            if ($perPage != INFX::perPage() && !INFX::IsNullOrEmptyString($prev_page)) $prev_page .= "&per_page=" . $perPage;

            $response['summary'] = [
                'total' => $plants->total(),
                'per_page' => $plants->perPage(),
                'current_page' => $plants->currentPage(),
                'last_page' => $plants->lastPage(),
                'next_page_url' => $next_page,
                'prev_page_url' => $prev_page,
                'from' => $plants->firstItem(),
                'to' => $plants->lastItem()
            ];

        }

        $returnPlants = [];

        foreach($plants as $plant)
        {
            $tempPlant = [
                'id' => $plant->plant_id,
                'botanical_name' => Plant::botanicalName($plant),
                'common_name' => $plant->common_name,
                'view_plant' => [
                    'href' => url('/api/v1/lvl') . '/' . $plant->plant_id,
                    'method' => 'GET'
                ]
            ];
            array_push($returnPlants, $tempPlant);
        }

        // Add the plants to the response
        $response['plants'] = $returnPlants;

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
        $plantDetails = Plant::where('plant_id', $id)->firstOrFail();

        $plant = [];

        $plant['id'] = $plantDetails->plant_id;
        $plant['botanical_name'] = Plant::botanicalName($plantDetails);
        $plant['common_name'] = $plantDetails->common_name;
        $plant['leaf_drop'] = Plant::leafDrop($plantDetails);

//        $plantDetails->botanical_name = Plant::botanicalName($plantDetails);

//        $plantDetails->view_plants = [
//            'href' => url('/api/v1/lvl'),
//            'method' => 'GET'
//        ];

        $response = [
            'msg' => 'Plant Information',
            'plant' => $plant,
            'plant_details' => $plantDetails,
            'view_plants' => [
            'href' => url('/api/v1/lvl'),
            'method' => 'GET'
            ]
        ];

        return response()->json($response, 200);
    }

}
