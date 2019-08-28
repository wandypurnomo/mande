<?php namespace App\Repositories;

use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\AuthRepositoryContract;
use Illuminate\Http\RedirectResponse;

class AuthRepository implements AuthRepositoryContract
{
    public $auth;

    public function __construct()
    {
        $this->auth = auth();
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (!$this->auth->attempt($request->only(["email", "password"]))) {
            return back()->withErrors(["failed" => __("auth.failed")]);
        }

        return redirect("/");
    }

    public function logout(): RedirectResponse
    {
        $this->auth->logout();
        return redirect("/")->withSuccess("Logout success");
    }
}