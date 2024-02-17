<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Jobs\UserLoginJob;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Repositories\API\UserRepo;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\LoginRequest;
use App\Repositories\API\UserLoginRepo;

class AuthController extends Controller
{
    private $userRepo;
    private $userLogin;
    public function __construct(UserRepo $userRepo, UserLoginRepo $userLogin)
    {
        $this->userRepo = $userRepo;
        $this->userLogin = $userLogin;
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userRepo->getActiveUser("email", $request->email);
            if(!$user){
                return response()->json(ResponseFormatter::failed(404, "Invalid username or password"), 404);
            }

            $userLogin = $this->userLogin->find($request->email);
            if(isset($userLogin) && !empty($userLogin->blocked_until) && Carbon::parse($userLogin->blocked_until)->isFuture()){
                $retry_at = Carbon::parse($userLogin->blocked_until)->diffForHumans();
                return response()->json(ResponseFormatter::failed(400, __("Your login attempt has exceeded the limit, please try again in $retry_at")), 400);
            }

            if(!Hash::check($request->password, $user->password)){
                dispatch(new UserLoginJob($request->email, $request->ip(), ERROR));
                return response()->json(ResponseFormatter::failed(400, __("Invalid username or password")), 400);
            }

            if(!$token = JWTAuth::fromUser($user)){
                return response()->json(ResponseFormatter::failed(400, __("Invalid credential")), 400);
            }

            dispatch(new UserLoginJob($request->email, $request->ip(), SUCCESS));
            return response()->json(ResponseFormatter::success(200, __("Authentication Successful"), [
                'access_token'  => $token,
                'refresh_token' => "",
                'token_type'    => 'Bearer',
                'expires_in'    => JWTAuth::factory()->getTTL() * 60,
            ]), 200);

        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function logout(Request $request)
    {
        JWTAuth::setToken($request->bearerToken())->invalidate();
        return response()->json(ResponseFormatter::failed(200, SUCCESS, __("Succesful Logout")), 200);       
    }

    public function checkToken(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->bearerToken());
            return response()->json(ResponseFormatter::success(200, __("Success"), $user), 200);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(401, UNAUTHORIZED, $e->getMessage()), 401);       
        }
    }
}
