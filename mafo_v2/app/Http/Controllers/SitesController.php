<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * SitesController constructor.
     */

    // TODO: remember including the auth middleware for the appropriate methods
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites= Site::all();

        foreach ($sites as $site){
            $idOfNewSite = $site->id;

            $site->links = [
                'view_site' => [
                    'href' => '/sites/'.$idOfNewSite,
                    'method' => 'GET'
                ],
                'view_drills' => [
                    'href' => '/sites/'.$idOfNewSite.'/drills',
                    'method' => 'GET'
                ],
                'view_coordinates' => [
                    'href' => '/sites/'.$idOfNewSite.'/coordinates',
                    'method' => 'GET'
                ],
                'view_images' => [
                    'href' => '/sites/'.$idOfNewSite.'/images',
                    'method' => 'GET'
                ]
            ];

        }

        $response = [
            'message' => 'Get list of sites',
            'sites' => $sites,
            'code' => 'OK'
        ];

        return response()->json($response, 200) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $otherInfo = $request->input('other_info');
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $site = new Site([
            'name' => $name,
            'other_info' => $otherInfo,
            'lat' => $lat,
            'lng' => $lng
        ]);

        if ($site->save()) {
            $idOfNewSite = $site->id;
            $site->links = [
                'view_site' => [
                    'href' => '/sites/'.$idOfNewSite,
                    'method' => 'GET'
                ],
                'delete_site' => [
                    'href' => '/sites/'.$idOfNewSite,
                    'method' => 'DELETE'
                ],
                'create_drill' => [
                    'href' => '/sites/'.$idOfNewSite.'/drills',
                    'method' => 'POST',
                    'params' => 'code, lat, lng, alt'
                ],
                'create_coordinate' => [
                    'href' => '/sites/'.$idOfNewSite.'/coordinates',
                    'method' => 'POST',
                    'params' => 'lat, lng, alt'
                ],
                'create_image' => [
                    'href' => '/sites/'.$idOfNewSite.'/images',
                    'method' => 'POST',
                    'params' => 'lien, type_image'
                ]
            ];
            $response = [
                'message' => 'Site created',
                'site' => $site,
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
        $site = Site::find($id);

        if( $site){
            $idOfNewSite = $site->id;
            $site->links = [
                'delete_site' => [
                    'href' => '/sites/'.$idOfNewSite,
                    'method' => 'DELETE'
                ],
                'view_drills' => [
                    'href' => '/sites/'.$idOfNewSite.'/drills',
                    'method' => 'GET'
                ],
                'view_coordinates' => [
                    'href' => '/sites/'.$idOfNewSite.'/coordinates',
                    'method' => 'GET'
                ],
                'view_images' => [
                    'href' => '/sites/'.$idOfNewSite.'/images',
                    'method' => 'GET'
                ]
            ];
            $response = [
                'message'=> 'showing a particular site',
                'site' => $site,
                'code' => 'OK'
            ];

            return response()->json($response, 200);
        }
        $response = [
            'message'=> 'No such resource does exist',
            'code' => 'ERROR'
        ];

        return response()->json($response, 404);
    }


    /**
     * Searches for all resources containing the query string.
     *
     * @param  int  $query
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $queryString = $request->query('q');
        return 'it works! from search '. $queryString;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//        //
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
        $name = $request->input('name');
        $otherInfo = $request->input('other_info');
        $lat = $request->input('lat');
        $lng = $request->input('lng');
//        $coordinates = $request->input('coordinates');

        $idOfNewSite = 2;

        $site = [
            'name' => $name,
            'other_info' => $otherInfo,
            'lat' => $lat,
            'lng' => $lng,
            'view_site' => [
                'view' => [
                    'href' => '/sites/'.$idOfNewSite,
                    'method' => 'GET'
                ],
                'drills' => [
                    'href' => '/sites/'.$idOfNewSite.'/drills',
                    'method' => 'POST'
                ],
                'coordinates' => [
                    'href' => '/sites/'.$idOfNewSite.'/coordinates',
                    'method' => 'POST'
                ],
                'images' => [
                    'href' => '/sites/'.$idOfNewSite.'/images',
                    'method' => 'POST'
                ]
            ]
        ];

        $response = [
            'message' => 'Meeting created',
            'site' => $site
        ];
        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // todo comme back here and fix the deletion by removing all of it's associated data.
    public function destroy($id)
    {
        if(Site::destroy([$id])) {
            $response = [
                'message'=>'ressource deleted successfully',
                'code' => 'OK'
            ];
            return response()->json($response, 201);
        }

        $response = [
            'message'=>'Error deleting resource',
            'code' => 'ERROR'
        ];
        return response()->json($response, 404);
    }
}
