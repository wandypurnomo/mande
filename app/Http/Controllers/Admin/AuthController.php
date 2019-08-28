<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(): View
    {
        return view("login");
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->repo->login($request);
    }

    public function logout(): RedirectResponse
    {
        return $this->repo->logout();
    }
}
