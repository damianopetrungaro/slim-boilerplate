<?php

namespace App\Services;

use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\Users\UserEloquentRepository;
use Slim\Middleware\JwtAuthentication;
use DI\ContainerBuilder;
use Valitron\Validator;
use DI\Bridge\Slim\App;

class Container extends App
{

    public function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
            Validator::class => function () {
                return new Validator($_POST, [ ], 'en');
            },
            UserRepositoryInterface::class => function () {
                return new UserEloquentRepository(new \App\Models\User());
            }
        ];
        $builder->addDefinitions($definitions);
    }
}