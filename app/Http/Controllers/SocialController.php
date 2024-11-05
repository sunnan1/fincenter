<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            $email = '';
            if ($user) {
                $email = $user->email;
            }
            $finduser = User::where('email', $email)->first();
            if ($finduser) {
                Auth::loginUsingId($finduser->id);
                return redirect('/');
            }
            $obj = new User();
            $obj->name = $user->name;
            $obj->email = $user->email;
            $obj->active = false;
            $obj->type = 'USER';
            $obj->save();
            Auth::loginUsingId($obj->id);
            return redirect()->to('/');
        } catch (\Exception $exception) {
           app('log')->error('Google Sign In Exception', ['exception' => $exception , 'file' => $exception->getFile(), 'line' => $exception->getLine()]);
        }
    }
}
