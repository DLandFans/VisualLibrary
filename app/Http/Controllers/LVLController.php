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
            $plants = Plant::orderBy('genus_name','asc')->orderBy('specific_epithet')->get(); //all();
        } else {
            $perPage = INFX::perPage();
            if(!INFX::IsNullOrEmptyString($request->input('per_page'))) $perPage = $request->input('per_page');

            $plants = Plant::orderBy('genus_name','asc')->orderBy('specific_epithet')->paginate($perPage);

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
                    'href' => url(INFX::v1()) . '/' . $plant->plant_id,
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
    public function show($id, Request $request)
    {

        $plantDetails = Plant::with('botanicalNames')
                            ->with('commonNames')
                            ->with('classifications')
                            ->with('flowerColors')
                            ->with('specifications')
                            ->with('plantImages')
                            ->with('plantNotes') // To Do
                            ->where('plant_id', $id)->firstOrFail();

        $plantDetails['bloom_months'] = Plant::bloomMonths($plantDetails);
        $plantDetails['alt_botanical_names'] = Plant::altBotanicalNames($plantDetails->botanicalNames);
        $plantDetails['alt_common_names'] = Plant::altCommonNames($plantDetails->commonNames);

        $plant = [];

        $plant['id'] = $plantDetails->plant_id;
        $plant['botanical_name'] = Plant::botanicalName($plantDetails);
        $plant['alternate_botanical_name_list'] = Plant::altBotanicalNamesList($plantDetails->botanicalNames);
        $plant['common_name'] = $plantDetails->common_name;
        $plant['alternate_common_name_list'] = Plant::altCommonNamesList($plantDetails->commonNames);
        $plant['type'] = Plant::leafDrop($plantDetails) . " " . Plant::plantClass($plantDetails->classifications);
        $plant['height'] = Plant::height($plantDetails);
        $plant['width'] = Plant::width($plantDetails);
        $plant['zone'] = Plant::zone($plantDetails);
        $plant['bloom_months_list'] = Plant::bloomMonthsList($plantDetails);
        $plant['flower_color'] = $plantDetails->flower_color_desc;
        $plant['sun_exposure'] = Plant::sunExposure($plantDetails);
        $plant['hardiness'] = Plant::hardiness($plantDetails);
        $plant['specifications'] = Plant::specificationsList($plantDetails->specifications);
        $plant['images'] = Plant::images($plantDetails->plantImages);
        $plant['notes'] = Plant::notes($plantDetails->plantNotes);


        $response = [
            'msg' => 'Plant Information',
            'info' => $plant,
            'view_plants' => [
                'href' => url(INFX::v1()),
                'method' => 'GET'
            ]
        ];

        if ((strtolower($request->input('detail')) == "true") || (strtolower($request->input('detail')) == "1")) {
            $response['plant_details'] = $plantDetails;
        } else {
            $response['view_plant_details'] = [
                'href' => url(INFX::v1()) . "/" . $plantDetails->plant_id . "?detail=true",
                'method' => 'GET'
            ];
        }

        return response()
            ->json($response, 200);
    }

}
