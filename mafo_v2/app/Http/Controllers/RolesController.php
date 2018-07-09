<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        foreach ($roles as $role){
            $role->links = [
                'delete_role' => [
                    'href' => '/roles/'.$role->id,
                    'method' => 'DELETE'
                ],
                'redirect_route' => [
                    'href' => $role->redirectRoute,
                ]
            ];
        }

        $response = [
            'message' => 'Get list of roles',
            'roles' => $roles
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
        $redirectRoute = $request->input('redirect_route');
        $role = new Role(['name' => $name, 'redirect_route' => $redirectRoute ]);
        if ($role->save()) {
            $role->links = [
                'delete_role' => [
                    'href' => '/roles/'.$role->id,
                    'method' => 'DELETE'
                ],
                'redirect_route' => [
                    'href' => $role->redirectRoute,
                ]
            ];
            $response = [
                'message' => 'Saving roles successful',
                'role' => $role,
                'code' => 'OK'
            ];

            return response()->json($response, 201);
        }

        $response = [
            'message' => 'Saving was unsuccessful',
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
