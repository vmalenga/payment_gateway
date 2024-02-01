<?php

namespace App\Repositories;

use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\User\UserResource;
use App\Models\Auth\Partner;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AuthRepository implements AuthRepositoryInterface
{
    public function verify(array $data): array
    {
        try{
            DB::beginTransaction();
            $partner = Partner::where(['client_token' => $data['token']])->first();

            if(!$partner){
                // TODO Invalid token
            }

            $response = null;
            $accessToken = null;
            if(!$partner->token || (int)$partner->expires_in <= strtotime(date('Y-m-d H:i:s'))){
                $data = [
                    'grant_type' => 'client_credentials',
                    'client_id' => $partner->client_id,
                    'client_secret' => $partner->client_token,
                    'scope' => '',
                ];

                $response = Http::asForm()->post(config('services.passport.token_endpoint'), $data);

                $partner->update([
                    'token' => $response->json()['access_token'],
                    'expires_in' => $response->json()['expires_in'] + strtotime(date('Y-m-d H:i:s')),
                ]);

                $accessToken = $response->json()['access_token'];
            }

            // dd($accessToken);

            if(!$accessToken){
                $accessToken = $partner->token;
            }

            $response = Http::withToken($accessToken)->get('http://127.0.0.1:8000/api/v1/test');

            
            DB::commit();

            return $response->json();
        }
        catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function login(array $data): array
    {
        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            return [
                'message' => 'The given data was invalid.',
                'errors' => [['email' => 'Incorrect email or password']]
            ];
        }
        else{
            $user = User::where(['email' => $data['email']])->first();

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

    public function verifyToken(array $data): array
    {
        $partner = Partner::find((int)$data['id']);

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $partner->client_id,
            'client_secret' => $partner->client_token,
            'scope' => '',
        ];

        $response = Http::asForm()->post(config('services.passport.token_endpoint'), $data);

        return [
            'accessToken' => $response->json()['access_token'],
            'refreshToken' => '',
            'tokenType' => $response->json()['token_type'],
            'expiresIn' => $response->json()['expires_in'],
            'user' => [
                'id' => $partner->id,
                'name' => $partner->name,
                'email' => '',
                'token' => '',
            ],
        ];
    }
}
