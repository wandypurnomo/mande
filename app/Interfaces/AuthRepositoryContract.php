<?php namespace App\Interfaces;

use App\Http\Requests\Auth\LoginRequest;

interface AuthRepositoryContract
{
    public function login(LoginRequest $request): bool;

    public function logout(): void;

    public function setGuard(String $guard): void;
}