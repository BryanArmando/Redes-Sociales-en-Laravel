<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialController extends Controller
{
    public function redirectToProvider($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();
   // dd($user);

   //para evitar la sobrecreacion del usuario verifica en la base y en caso de no existir lo crea.

   $user = User::firstOrCreate(
    [
         'provider_id' => $socialiteUser->getId()
     ],
     [
         'email' => $socialiteUser->getEmail(),
         'name' => $socialiteUser->getName(), 
     ]
 );

    //log the user
    auth()->login($user, true);

    //redirect
    return redirect('/dashboard');
    }
}
