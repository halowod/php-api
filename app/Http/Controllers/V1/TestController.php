<?php

namespace Controllers\V1;

use Controllers\Controller;
use Illuminate\Http\Request;

/**
 * test qin
 * 2018-04-17 14:40
 */
class TestController extends Controller
{
    public function index(Request $request)
    {
//        echo config('appkey.'.'e9d83b7f7751253d663dfd8ebbd4513c');
//        echo hash_hmac('md5', 'e9d83b7f7751253d663dfd8ebbd4513c', 'appkey');
//        echo password_hash(123456, PASSWORD_DEFAULT);
        
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['name', 'password']);
        \Auth::attempt();
        \Auth::once();
        \App::version();
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
}
