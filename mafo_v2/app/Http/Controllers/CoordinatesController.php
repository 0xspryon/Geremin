<?php

namespace App\Http\Controllers;

use App\Coordinate;
use App\Site;
use Illuminate\Http\Request;

class CoordinatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idOfNewSite = $request->route('site_id');

        $alt = $request->input('alt');
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $coordinate = new Coordinate([
            'alt' => $alt,
            'lat' => $lat,
            'lng' => $lng
        ]);

        $site = Site::find($idOfNewSite);

        if ($site->coordinates()->save($coordinate)) {
            $coordinate->links = [
                'view_coordinate' => [
                    'href' => '/sites/'.$idOfNewSite."/".$coordinate->id,
                    'method' => 'GET'
                ],
                'delete_site' => [
                    'href' => '/sites/'.$idOfNewSite."/".$coordinate->id,
                    'method' => 'DELETE'
                ]
            ];
            $response = [
                'message' => 'Coordinate created',
                'site' => $coordinate,
                'code' => 'OK'
            ];
            return response()->json($response, 201);
        }

        $response = [
            'message' => 'Error creating meeting',
            'code' => 'ERROR'
        ];

        return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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
        //
    }
}
