<?php

namespace App\Services;

use App\Repositories\Users\PDOUserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Valitron\Validator;

class Container extends App
{

    public function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
            Validator::class               => function () {
                return new Validator($_POST, [ ], 'en');
            },
            UserRepositoryInterface::class => function () {
                return new PDOUserRepository();
            }
        ];
        $builder->addDefinitions($definitions);
    }
}