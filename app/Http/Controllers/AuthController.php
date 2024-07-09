<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request->email, $request->password);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authService->register($request->name, $request->email, $request->password);
    }
}
