<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index()
    {
        return view('backend/admin/account/index');
    }


    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        Session::flash('message', 'Account updated successfully');
        return redirect()->back();
    }


    public function updatePassword(Request $request)
    {
        $this->validate($request, [

            'new_password' => ['required', 'min:6', 'same:conform_password'],
            'conform_password' => ['same:new_password'],
        ]);

        $user = User::find(Auth::id());

        $user->password = Hash::make($request->new_password);
        $user->save();
        Session::flash('message', 'Password updated successfully');
        return redirect()->back();
    }
}
