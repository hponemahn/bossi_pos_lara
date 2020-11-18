<?php

namespace App\GraphQL\Mutations;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function login($_, array $args)
    {
        $credentials = Arr::only($args, ['email', 'password']);

        if (Auth::once($credentials)) {
            $token = Str::random(60);

            $user = auth()->user();
            $user->api_token = $token;
            $user->save();

            return $token;
        }

        return null;
    }

    public function register($_, array $args)
    {
        $res;
        $user = User::select('id')->Where('email', $args['email'])->get();

        if (count($user) > 0) {
            $res = "1";
        } else {
            $r = User::create(
                ['name' => $args['name'], 'logo' => $args['logo'], 'business_cat_id' => $args['business_cat_id'], 'device_id' => $args['device_id'], 'email' => $args['email'], 'password' => Hash::make($args['password']), 'state_id' => $args['state_id'], 'township_id' => $args['township_id'], 'api_token' => Str::random(60)]
            );
        }

        $res = $r->api_token;

        return $res;

    }
}
