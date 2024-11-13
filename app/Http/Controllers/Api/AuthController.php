<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\LoginOtp;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        # By default we are using here auth:api middleware
        # $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token); # If all credentials are correct - we are going to generate a new access token and send it back on response
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        # Here we just get information about current user
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(); # This is just logout function that will destroy access token of current user

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        # When access token will be expired, we are going to generate a new one wit this function 
        # and return it here in response
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        # This function is used to make JSON response with new
        # access token of current user
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 2
        ]);
    }




    public function login_with_mobile(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required|string|min:10|max:10'
        ]);

        $user = User::where('phone', $request->phone)->get()->first();

        if($user) {
            $otp = '111111';

            $obj = new LoginOtp();
            $obj->user_id = $user->id;
            $obj->otp = $otp;
            $obj->status = 1;
            $obj->save();

            $data = [
                'user' => $user->id
            ];

            return response()->json(['success' => true, 'message' => 'User Found', 'data' => $data], 200);
        }
        else {
            return response()->json(['success' => false, 'message' => 'User Not Found'], 401);
        } 
    }



    public function verify_otp(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'otp' => 'required|string|min:6|max:6'
        ]);

        $user_otp = LoginOtp::where('user_id', $request->user_id)->get()->first();

        if($user_otp->otp == $request->otp) {
            $token = auth('api')->tokenById($user_otp->user_id);
            return $this->respondWithToken($token);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }


}



