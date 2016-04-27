<?php

namespace App\Services;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Valitron\Validator;

class Container extends App
{
    public function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
            Validator::class => function() {
                return new Validator($_POST, [], 'en');
            }
        ];
        $builder->addDefinitions($definitions);
    }
}