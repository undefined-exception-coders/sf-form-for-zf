<?php

namespace UEC\SymfonyFormForZendFramework\Factory\UECStandaloneSymfonyForm;

use Interop\Container\ContainerInterface;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\SymfonyFormForZendFramework\PluginManager\ConstraintPluginManager;
use UEC\SymfonyFormForZendFramework\Validator\ZendConstraintValidatorFactory;

class ValidationBuilderFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $config = $services->get('config');
        $moduleConfig = $config[Module::class];

        $factory = new \UEC\Standalone\Symfony\Form\ValidationBuilderFactory();

        $validation = $factory();
        $validation->setTranslator($services->get($moduleConfig['translator']['service']));
        $validation->setTranslationDomain($moduleConfig['translator']['domain']);
        $validation->setConstraintValidatorFactory(new ZendConstraintValidatorFactory($services->get(ConstraintPluginManager::class)));

        return $validation;
    }
}