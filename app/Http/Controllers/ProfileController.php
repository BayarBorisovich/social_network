<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationRequest;
use App\Http\Requests\UserRequest;
use App\Models\Information;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController
{
    public function showProfileForm(): View
    {
        $user = Auth::user();

        return view('user.updateUser', compact('user'));
    }

    public function updateProfile(UserRequest $request): RedirectResponse
    {
        Auth::user()->update($request->validated());

        return redirect()->back()->withSuccess('the changes were successful');
    }

    public function updateOrCreateInformation(InformationRequest $request): RedirectResponse
    {
        $data = array_merge(
            $request->only(['surname', 'patronymic', 'telephone', 'city', 'about_me']),
            ['user_id' => Auth::id()]
        );

        Information::query()->updateOrCreate(
            ['user_id' => Auth::id()], // Условие поиска
            $data // Данные для обновления или создания
        );

        return redirect()->back()->withSuccess('The changes were successful');
    }
}
