<?php

namespace App\Providers;

use DI\Bridge\Slim\App;
use Valitron\Validator;
use DI\ContainerBuilder;
use App\Acme\JWT\Manager;
use App\Acme\JWT\Manager as JWT;
use Interop\Container\ContainerInterface;
use App\Repositories\Users\UserEloquentRepository;
use App\Repositories\Users\UserRepositoryInterface;

class Container extends App
{
	public function configureContainer(ContainerBuilder $builder)
	{
		$definitions = [
			'errorHandler' => function () {
				return new \App\Acme\Handlers\Error(getenv('DEBUG'));
			},
			Validator::class => function () {
				return new Validator($_POST, [], 'en');
			},
			JWT::class => function (ContainerInterface $container) {
				$config = [
					'header-param' => getenv('JWT_HEADER_PARAMS'),
					'issuer' => getenv('JWT_ISSUER'),
					'audience' => getenv('JWT_AUDIENCE'),
					'id' => getenv('JWT_ID'),
					'sign' => getenv('JWT_SIGN'),
				];

				return new Manager($container->get('request'), $config);
			},
			UserRepositoryInterface::class => function () {
				return new UserEloquentRepository(new \App\Models\User());
			},
		];

		$builder->addDefinitions($definitions);
	}
}