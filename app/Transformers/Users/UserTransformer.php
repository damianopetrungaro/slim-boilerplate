<?php
/**
 * Created by PhpStorm.
 * User: damianopetrungaro
 * Date: 08/05/16
 * Time: 16:11
 */

namespace App\Transformers\Users;

use App\Transformers\AbstractTransformer;

class UserTransformer extends AbstractTransformer
{

    public function item($user)
    {
        return [
            'id'         => (int) $user['id'],
            'attributes' => [
                'name'    => $user['name'],
                'surname' => $user['surname'],
                'email'   => $user['email'],
            ],
            'links'      => [
                [
                    'self'    => '/users/' . $user['id'],
                    'related' => [ ],
                ]
            ],
        ];
    }
}