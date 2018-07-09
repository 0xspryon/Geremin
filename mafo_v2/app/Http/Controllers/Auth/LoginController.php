<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Logs in a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password') ;

//        $user1 = User::create([
//            'name' => $name,
//            'email' => $email,
//            'api_token' => $api_token,
//            'password' => $password,
//        ]);

        $user = User::with('role')->where('email', $email)->first();
        $user->makeVisible('api_token');

//        $user->makeVisible('password');
        $dbUserPassword = Crypt::decrypt($user->password, ['serialize' => true]);

        if (!($dbUserPassword == $password)) {
            $wrongLoginResponse = [
                'message' => 'Sorry, wrong login parameters( username and password)',
                'code' => 'ERROR'
            ];
            return response()->json($wrongLoginResponse, 401);
        }


        $response = [
            'message' => 'Login successful',
            'user' => $user,
            'code' => 'OK',
            'links' => [
                'authentication_token_string' => 'Bearer '.$user->api_token
            ]
        ];

        return response()->json($response, 201);
    }

    public function current(Request $request){
        $apiToken= substr($request->header('Authorization'), 7);
        $user = DB::select(
            'select * from users where api_token = ?',
            [$apiToken]
        );
//        User::find($apiToken);
        if ($user){
            return response()->json(
                [
                    'code' => 'OK',
                    'user' => $user
                ],
                200
            );
        }

        $guestUser = (object) [
            'name' => 'Guest',
            'email' => 'Guest@guest.com',
            'api_token' => '8hNcPb9pETanYyqh8P7b0FBLMmyPNeMbV0dWyuqO10Y1oUcZliry8Year5vs'
        ];

        return response()->json([
                'message'=> 'Guest',
                'user' => $guestUser
            ],
            200
        );
    }
}
