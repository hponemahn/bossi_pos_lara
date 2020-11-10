<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\User;
use App\Products;
use GraphQL\Error\Error;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
     public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
         if($args['email'] == "null"){
            $user = User::where('phone', '=', $args['phone'])
             ->where('device_ID', '=', $args['device_ID'])
             ->first();
             
            if(!$user)
                {
                    return new Error('EMAIL_NOT_FOUND');
                }else{

                $credentials = Arr::only($args, ['phone', 'password']);

                if (!Auth::once($credentials))
                    return new Error('LOGIN_FAILS');

                $token = Str::random(60);

                $user = auth()->user();
                $user->api_token = $token;
                if(!$user->save())
                    return new Error('USER_CANNOT_SAVE');
                return $user;
                }
            }else{
                $user = User::where('email', '=', $args['email'])
                 ->where('device_ID', '=', $args['device_ID'])
                 ->first();
                 
                if(!$user)
                    {
                        return new Error('EMAIL_NOT_FOUND');
                    }else{

                    $credentials = Arr::only($args, ['email', 'password']);

                    if (!Auth::once($credentials))
                        return new Error('LOGIN_FAILS');

                    $token = Str::random(60);

                    $user = auth()->user();
                    $user->api_token = $token;
                    if(!$user->save())
                        return new Error('USER_CANNOT_SAVE');
                    return $user;
                    }
            }

    }

    public function signup($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = new User($args);
        $user->device_ID = $args['device_ID'];
        $user->business_name = $args['business_name'];
        $user->state_id = $args['state_id'];
        $user->role_id = $args['role_id'];

        if($args['avatar'] == null){
           $user->avatar = 'users\\default.png';
        }else{
            $year = date("Y");
            $month =  date("F");
            $tmp = $month.$year;
            $file = $args['avatar'];        
            $file_name = $file->hashName();
            $path = $file->move(public_path('\storage\photo\\'.$tmp.'\\'), $file_name);
            $photo_url = 'photo\\'.$tmp.'\\'.$file_name; //url('/storage/users/'.$file_name);
            $user->avatar = $photo_url;
        }

       
        //Auth
        $credentials = Arr::only($args, ['email', 'password']);
        $token = Str::random(60);
        $user->api_token  = $token;


        if(!$user->save())
            return new Error('USER_CANNOT_SAVE');
        return $user;
    }

    public function gmail_signup($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $users = User::where('email', '=', $args['email'])->first();

        if($users)
        {
            return $users;
        }else{

            $user = new User($args);
            $user->business_name = $args['business_name'];
            $user->state_id = $args['state_id'];

            if(!$user->save())
                return new Error('USER_CANNOT_SAVE');
            return $user;
        }
    }
}
