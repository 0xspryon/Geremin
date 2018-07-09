<?php

namespace App\Http\Controllers;

use App\AnalysisParameter;
use App\Analysis;
use Illuminate\Http\Request;

class AnalysesParametersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $analysisId;

    public function index(Request $request)
    {
        $this->analysisId = $request->route('analysis_id');
        $analysis = Analysis::find($this->analysisId);

        $analysisParameters = $analysis->analysesParameter;

        if ($analysisParameters->isNotEmpty()) {

            foreach ($analysisParameters as $analysisParameter) {
                $analysisParameter->links = [
                    'delete_analysis_parameter' => [
                        'href' => '/analyses/' . $analysis->id . '/analysis_parameter/' . $analysisParameter->id,
                        'method' => 'DELETE'
                    ]
                ];
            }

            $response = [
                'message' => 'List of all analysis parameters',
                'code' => 'OK',
                'analysis_parameter' => $analysisParameters
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message' => 'List of all analysis parameters',
            'code' => 'OK',
            'analysis_parameter' => []
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $this->analysisId = $request->route('analysis_id');
        $analysis = Analysis::find($this->analysisId);
//        return response()->json( $this->analysisId, 200);
        if($analysis) {
            $analysisParameter = new AnalysisParameter([
                        'name_analysis_parameter' => $request->input('name_analysis_parameter')
                    ]);

            if ($analysis->analysesParameter()->save($analysisParameter)) {
                $analysisParameter->links = [
                    'delete_analysis_parameter' => [
                        'href' => '/analyses/' . $analysis->id . '/analysis_parameter/' . $analysisParameter->id,
                        'method' => 'DELETE'
                    ]
                ];

                $response = [
                    'message' => 'Resource created successfully',
                    'code' => 'OK',
                    'analysis_parameter' => $analysisParameter
                ];

                return response()->json($response, 201);
            }
        }

        $response = [
            'message' => 'Creation unsuccessful',
            'code' => 'ERROR'
        ];

        return response()->json($response, 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id1, $id2)
    {
        $this->analysisId = $request->route('analysis_id');
        $id = $request->route('analysis_parameter');
        $analysis = Analysis::find($this->analysisId);
        $analysisParameter = AnalysisParameter::find($id) ;
        if ($analysisParameter){
            $analysisParameter->links = [
                'delete_analysis_parameter' => [
                    'href' => '/analyses/' . $analysis->id . '/analysis_parameter/' . $analysisParameter->id,
                    'method' => 'DELETE'
                ]
            ];
            $response = [
                'message' => 'Showing a resource',
                'code' => 'OK',
                'analysis_parameter' => $analysisParameter
            ];

            return response()->json($response, 200);
        }

        $response = [
        'message' => 'resource not found',
        'code' => 'ERROR'
        ];

        return response()->json($response, 404);

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
    public function destroy(Request $request )
    {
        $idToBeDeleted = $request->route('analysis_parameter');
        if(AnalysisParameter::destroy($idToBeDeleted)){
            $response = [
                'message' => 'Ressource successfully deleted',
                'code' => 'OK'
            ];
            return response()->json($response, 201);
        }
        $response = [
            'message' => 'Error deleting resource',
            'code' => 'ERROR'
        ];
        return response()->json($response, 405);
    }
}
