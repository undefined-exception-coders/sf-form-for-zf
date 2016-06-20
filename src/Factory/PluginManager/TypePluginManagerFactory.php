<?php

namespace UEC\SymfonyFormForZendFramework\Factory\PluginManager;

use Interop\Container\ContainerInterface;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\SymfonyFormForZendFramework\PluginManager\TypePluginManager;
use Zend\ServiceManager\Config;

class TypePluginManagerFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $config = $services->get('config');

        $constraintConfig = new Config($config[Module::class]['types']['container']);
        $typeServices = new TypePluginManager($constraintConfig);
        $typeServices->setServiceLocator($services);
        return $typeServices;
    }
}