<?php

declare(strict_types=1);

namespace App\Transformers\Users;

use App\Transformers\AbstractTransformer;

class UserTransformer extends AbstractTransformer
{
    public function item($user): array
    {
        return [
            'id' => $user['id'],
            'attributes' => [
                'name' => $user['name'],
                'surname' => $user['surname'],
                'email' => $user['email'],
            ],
            'links' => [
                [
                    'self' => '/users/' . $user['id'],
                    'related' => [],
                ],
            ],
        ];
    }
}
