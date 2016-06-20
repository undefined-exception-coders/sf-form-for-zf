<?php

namespace UEC\SymfonyFormForZendFramework\Factory\PluginManager;

use Interop\Container\ContainerInterface;
use UEC\SymfonyFormForZendFramework\Module;
use UEC\SymfonyFormForZendFramework\PluginManager\ExtensionPluginManager;
use Zend\ServiceManager\Config;

class ExtensionPluginManagerFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $config = $services->get('config');
        $moduleConfig = $config[Module::class];

        $extensionServicesConfig = $moduleConfig['extensions']['container'];
        $extensionServices = new ExtensionPluginManager(new Config($extensionServicesConfig));
        $extensionServices->setServiceLocator($services);
        return $extensionServices;
    }
}