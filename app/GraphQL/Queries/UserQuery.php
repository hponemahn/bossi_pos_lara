<?php

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\Auth;

class UserQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function me($_, array $args)
    {
        return Auth::guard('api')->user();
    }
}
