<?php

namespace UEC\SymfonyFormForZendFramework\Factory\PluginManager;

use Interop\Container\ContainerInterface;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\SymfonyFormForZendFramework\PluginManager\ConstraintPluginManager;
use Zend\ServiceManager\Config;

class ConstraintPluginManagerFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $config = $services->get('config');

        $constraintConfig = new Config($config[Module::class]['constraints']);
        $constraintServices = new ConstraintPluginManager($constraintConfig);
        $constraintServices->setServiceLocator($services);
        return $constraintServices;
    }
}