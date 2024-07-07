<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function showLogin(): Response {
        return Inertia::render('Auth/Login');
    }

    /**
     * @throws ValidationException
     */
    public function doLogin(AuthLoginRequest $request): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended();
    }

    public function doLogout(Request $request): RedirectResponse {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('index'));
    }

    public function showRegister(): Response {
        return Inertia::render('Auth/Register');
    }

    public function doRegister(AuthRegisterRequest $request): RedirectResponse {
        $user = User::create([
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(route('index'));
    }
}
