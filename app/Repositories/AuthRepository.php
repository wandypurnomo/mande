<?php namespace App\Repositories;

use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\AuthRepositoryContract;

class AuthRepository implements AuthRepositoryContract
{
    public $auth;
    public $guard;

    public function __construct()
    {
        $this->auth = auth();
    }

    public function login(LoginRequest $request): bool
    {
        return $this->auth->attempt($request->only(["email", "password"]));
    }

    public function logout(): void
    {
        $this->auth->logout();
    }

    public function setGuard(String $guard): void
    {
        $this->guard = $guard;
        $this->auth = auth($this->guard);
    }
}