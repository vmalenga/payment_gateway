<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return Response([
                'message' => 'The given data was invalid.',
                'errors' => [['email' => 'Incorrect email or password']]
            ], Response::HTTP_UNAUTHORIZED);
        }
        else{
            $user = User::where(['email' => $request->email])->first();

			$tokenResult = $user->createToken('PaymentsGateway');

            return [
                'accessToken' => $tokenResult->accessToken,
                'refreshToken' => '',
                'tokenType' => 'Bearer',
                'expireIn' => Carbon::now()->diffInSeconds($tokenResult->token->expires_at),
                'exipireTime' => 0,
                'user' => new UserResource($user),
            ];
        }
    }
}
