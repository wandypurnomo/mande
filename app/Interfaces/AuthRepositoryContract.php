<?php namespace App\Interfaces;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;

interface AuthRepositoryContract
{
    public function login(LoginRequest $request): RedirectResponse;

    public function logout(): RedirectResponse;
}