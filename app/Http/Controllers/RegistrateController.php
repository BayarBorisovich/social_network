<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrateController extends Controller
{
    public function getForm(): View
    {
        return view('registrate');
    }

    public function postRegistrate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8|string', //confirmed
            'phone' => 'required|string|max:14',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'about_of_me' => 'string|nullable',
        ]);



        DB::table('users')->insert([
            '_token' => $request->all()['_token'],
            'name' => $request->all()['name'],
            'surname' => $request->all()['surname'],
            'patronymic' => $request->all()['patronymic'],
            'email' => $request->all()['email'],
            'password' => Hash::make($request->all()['password']),
            'phone' => $request->all()['phone'],
            'date_of_birth' => $request->all()['date_of_birth'],
            'gender' => $request->all()['gender'],
            'about_of_me' => $request->all()['about_of_me'],
        ]);

        return redirect()->route('login');


    }

}
