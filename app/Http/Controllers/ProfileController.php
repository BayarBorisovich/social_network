<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationRequest;
use App\Http\Requests\UserRequest;
use App\Models\Information;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController
{
    public function showProfileForm(): View
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(UserRequest $request): RedirectResponse
    {
        try {
            Auth::user()->update($request->validated());

            return redirect()->back()->withSuccess('the changes were successful');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->withErrors('error when changing profile data');
        }
    }

    public function updateOrCreateInformation(InformationRequest $request): RedirectResponse
    {
        try {
            $data = array_merge(
                $request->only(['surname', 'patronymic', 'telephone', 'city', 'about_me']),
                ['user_id' => Auth::id()]
            );

            Information::query()->updateOrCreate(
                ['user_id' => Auth::id()], // Условие поиска
                $data // Данные для обновления или создания
            );

            return redirect()->back()->withSuccess('The changes were successful');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->withErrors('error when changing profile data');
        }

    }
}
