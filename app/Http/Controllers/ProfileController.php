<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function renewToken()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->api_token = Str::random(60);
        $user->save();
        flash(__('API Token changed successfully.'))->success();
        return redirect()->route('profile');
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'name' => 'required|string'
        ])->validate();
        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        flash(__('Information saved successfully.'))->success();
        return redirect()->route('profile');
    }

    public function password(Request $request)
    {
        Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6|different:current_password',
            'password_confirmation' => 'required|min:6|different:current_password',
        ])->validate();
        $user = User::findOrFail(auth()->user()->id);
        if (Auth::attempt(['email' => $user->email, 'password' => $request->current_password])) {
            $user->password = bcrypt($request->password);
            $user->save();
            flash('Password changed successfully.')->success();
            return redirect()->route('profile');
        } else {
            flash('Data is incorrect.')->error();
            return redirect()->route('profile');
        }
    }
}
