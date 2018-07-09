<?php

namespace App\Http\Controllers;

use App\Analysis;
use Illuminate\Http\Request;
use Illuminate\View\Concerns\ManagesLayouts;

class AnalysesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $analyses = Analysis::all();
        if ($analyses->isNotEmpty() ) {
            foreach ($analyses as $analysis) {
                $analysis->links = [
                    'view_analysis' => [
                        'href' => '/analyses/' . $analysis->id,
                        'method' => 'GET'
                    ],
                    'delete_analysis' => [
                        'href' => '/analyses/' . $analysis->id,
                        'method' => 'DELETE'
                    ],
                    'create_analysis_param' => [
                        'href' => '/analyses/' . $analysis->id . '/analysis_param',
                        'method' => 'POST'
                    ]
                ];

            }
            $response = [
                'message' => 'List of all analyses',
                'analyses' => $analyses,
                'code' => 'OK'
            ];

            return response()->json($response, 200);
        }
        $response = [
            'message' => 'List of all analyses',
            'analysis' => [],
            'code' => 'OK'
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeAnalysis = $request->input('analysis_type');
        $protocol = $request->input('protocol');
        $equipments = $request->input('equipments');
        $otherInfo = $request->input('other_info');

        $analysis = new Analysis([
            'analysis_type' => $typeAnalysis ,
            'protocol' => $protocol,
            'equipments' => $equipments,
            'other_info' => $otherInfo
        ]);

        if ($analysis->save()) {
            $analysis->links= [
                'view_analysis' => [
                    'href' => '/analyses/'.$analysis->id,
                    'method' => 'GET'
                ],
                'create_analysis_param' => [
                    'href' => '/analyses/'.$analysis->id.'/analysis_parameter',
                    'method' => 'POST'
                ]
            ];

            $response = [
                'message' => 'Analysis created successfully',
                'analysis' => $analysis,
                'code' => 'OK'
            ];

            return response()->json($response, 201);
        }
        $response = [
            'message' => 'Saving unsuccessful',
            'code' => 'ERROR'
        ];

        return response()->json($response, 400);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analysis = Analysis::find($id);
        if ($analysis) {
            $analysis->links= [
                'delete_analysis' => [
                    'href' => '/analyses/'.$analysis->id,
                    'method' => 'DELETE'
                ],
                'create_analysis_param' => [
                    'href' => '/analyses/'.$analysis->id.'/analysis_param',
                    'method' => 'POST'
                ]
            ];

            $response = [
                'message' => 'Analysis created successfully',
                'analysis' => $analysis,
                'code' => 'OK'
            ];

            return response()->json($response, 201);
        }
        $response = [
            'message' => 'No resource of this type found',
            'code' => 'ERROR'
        ];

        return response()->json($response, 404);
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
        if(Analysis::destroy($id)){
            $response = [
                'message' => 'Resource deleted successfully',
                'code' => 'OK'
            ];
            return response()->json($response, 201) ;
        }
        $response = [
            'message' => 'This resource doesn\'t exist',
            'code' => 'ERROR'
        ];
        return response()->json($response, 200) ;
        //
    }
}
