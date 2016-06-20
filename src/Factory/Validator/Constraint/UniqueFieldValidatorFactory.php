<?php

namespace UEC\SymfonyFormForZendFramework\Factory\Validator\Constraint;

use Interop\Container\ContainerInterface;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\SymfonyFormForZendFramework\Validator\Constraint\UniqueFieldValidator;

class UniqueFieldValidatorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();
        $config = $serviceLocator->get('config');

        return new UniqueFieldValidator($serviceLocator->get($config[Module::class]['object_manager']));
    }
}