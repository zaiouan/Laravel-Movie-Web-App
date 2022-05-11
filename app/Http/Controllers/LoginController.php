<?php

namespace App\Http\Controllers;
use File;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Str;
use Hash;

class LoginController extends Controller
{
    public function facebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookRedirect(){
        $user=Socialite::driver('facebook')->stateless()->user();
        $fileContents = file_get_contents($user->getAvatar());
        File::put( public_path()."/img/". $user->getId() . ".jpg", $fileContents);
        $picture = $user->getId() . ".jpg";
        $user= User::firstOrCreate([
            'email' => $user->email,
        ],[
            'name' => $user->name,
            'password' => Hash::make(Str::random(24)),
            'picture'=> $picture
        ]);
        if(!$user->hasRole('user')){
            $user->attachRole('user');
        }
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
    public function google(){
        return Socialite::driver('google')->redirect();
    }
    public function googleRedirect(){
        $user=Socialite::driver('google')->stateless()->user();
        $user= User::firstOrCreate([
            'email' => $user->email,
        ],[
            'name' => $user->name,
            'password' => Hash::make(Str::random(24)),
            'picture'=> $user->avatar_original
        ]);

        if(!$user->hasRole('user')){
            $user->attachRole('user');
        }
       Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
