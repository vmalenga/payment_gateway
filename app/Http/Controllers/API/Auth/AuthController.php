<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthVerifyTokenRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected AuthRepositoryInterface $auth;

    public function __construct(AuthRepositoryInterface $auth)
    {
        $this->auth = $auth;
    }

    public function verify(Request $request)
    {
        return $this->auth->verify($request->all());
    }

    public function login(Request $request)
    {
        return $this->auth->login($request->all());
    }

    public function verifyToken(AuthVerifyTokenRequest $request)
    {
        return $this->auth->verifyToken($request->all());
    }
}
