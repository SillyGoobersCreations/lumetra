<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\Attendee;
use App\Models\Event;
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

    public function showEventGate(): Response {
        return Inertia::render('Auth/EventGate');
    }

    /**
     * @throws ValidationException
     */
    public function doLogin(AuthLoginRequest $request): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();

        $userEventCount = Attendee::where(['user_id' => Auth::user()->id])->with(['event'])->count();

        if($userEventCount > 0) {
            return redirect()->intended(route('eventGate'));
        } else {
            return redirect()->intended(route('events.index'));
        }
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

        $publicEventCount = Event::where(['state' => 'public'])->count();
        if($publicEventCount > 1) {
            return redirect(route('events.index'));
        } else {
            $event = Event::where(['state' => 'public'])->first();

            return redirect(route('events.detail.enroll', [
                'eventId' => $event->id,
            ]));
        }
    }
}
