<?php

namespace App\GraphQL\Mutations;

class UploadFiles
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $file = $args['logoImageFile'];

        return $file->storePublicly('uploads');

    }
}
