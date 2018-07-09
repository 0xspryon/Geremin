<?php

namespace App\Http\Controllers;

use App\Drill;
use App\Site;
use Illuminate\Http\Request;

class DrillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idOfSiteOFDril = $request->route('site_id');
        $drills = Site::find($idOfSiteOFDril)->drills;

        foreach ($drills as $drill){
            $idOfDrill = $drill->id;

            $drill->links = [
                'delete_drill' => [
                    'href' => '/sites/'.$idOfSiteOFDril.'/'.$idOfDrill,
                    'method' => 'DELETE'
                ]
            ];
        }

        return response()->json($drills , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = $request->input('code') ;
        $lat = $request->input('lat') ;
        $lng = $request->input('lng') ;
        $alt = $request->input('alt') ;

        $idOfSiteOFDril = $request->route('site_id');

        $drill = new Drill([
            'code' => $code,
            'lat' => $lat,
            'lng' => $lng,
            'alt' => $alt,
        ]);

        $site = Site::find($idOfSiteOFDril);

        if ( $site->drills()->save($drill) ) {
            $idOfNewDril = $drill->id;

            $drill->links = [
                'delete_drill' => [
                    'href' => '/sites/'.$idOfSiteOFDril.'/'.$idOfNewDril,
                    'method' => 'DELETE'
                ]
            ];
        }

        $response = [
            'message' => 'Drill created',
            'dril' => $drill
        ];
        return response()->json($response, 201) ;
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        $idOfSiteOFDril = $request->route('site_id');
//
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Drill::destroy([$id])) {
            $response = [
                'message' => 'Drill deleted',
                'code' => 'OK'
            ];
            return response()->json($response, 201);
        }
    }
}
