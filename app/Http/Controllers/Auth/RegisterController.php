<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegistrateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * @throws \Exception
     */
    public function register(RegistrateRequest $request): RedirectResponse
    {
        $data = $request->all();

        $user = User::create([
            '_token' => $data['_token'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        return redirect()->route('login');

    }
}
