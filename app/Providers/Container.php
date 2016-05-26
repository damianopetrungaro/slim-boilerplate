<?php

namespace App\Providers;

use DI\Bridge\Slim\App;
use Valitron\Validator;
use DI\ContainerBuilder;
use App\Repositories\Users\UserEloquentRepository;
use App\Repositories\Users\UserRepositoryInterface;

class Container extends App
{
    public function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
            'settings.displayErrorDetails' => getenv('DEBUG') ?: false,
            Validator::class => function () {
                return new Validator($_POST, [], 'en');
            },
            UserRepositoryInterface::class => function () {
                return new UserEloquentRepository(new \App\Models\User());
            },
        ];

        $builder->addDefinitions($definitions);
    }
}