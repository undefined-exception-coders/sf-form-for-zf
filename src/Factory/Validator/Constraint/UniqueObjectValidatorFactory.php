<?php

namespace UEC\SymfonyFormForZendFramework\Factory\Validator\Constraint;

use Interop\Container\ContainerInterface;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\SymfonyFormForZendFramework\Validator\Constraint\UniqueObjectValidator;

class UniqueObjectValidatorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();
        $config = $serviceLocator->get('config');

        return new UniqueObjectValidator($serviceLocator->get($config[Module::class]['object_manager']));
    }
}