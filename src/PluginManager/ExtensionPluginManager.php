<?php

namespace UEC\SymfonyFormForZendFramework\PluginManager;

use Symfony\Component\Form\FormExtensionInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class ExtensionPluginManager extends AbstractPluginManager
{
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof FormExtensionInterface) {
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugins managed by "%s" must implement "%s". "%s" provided',
            __CLASS__,
            FormExtensionInterface::class,
            is_object($plugin) ? get_class($plugin) : gettype($plugin)
        ));
    }

}