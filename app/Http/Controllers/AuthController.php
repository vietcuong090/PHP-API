<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthServiceImplement;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    private AuthServiceImplement $authServiceImpl;

    public function __construct(AuthServiceImplement $authServiceImpl)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authServiceImpl = $authServiceImpl;
    }

    public function register(Request $request)
    {
        return $this->authServiceImpl->register($request);
    }

    public function login(Request $request)
    {
        return $this->authServiceImpl->login($request);
    }

    public function logout()
    {
        return $this->authServiceImpl->logout();
    }


    public function refresh()
    {
        return $this->authServiceImpl->refresh();
    }
}