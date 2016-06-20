<?php

namespace UEC\SymfonyFormForZendFramework\PluginManager;

use Symfony\Component\Form\FormTypeInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class TypePluginManager extends AbstractPluginManager
{
    /**
     * @inheritDoc
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof FormTypeInterface) {
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugins managed by "%s" must implement "%s". "%s" provided',
            __CLASS__,
            FormTypeInterface::class,
            is_object($plugin) ? get_class($plugin) : gettype($plugin)
        ));
    }
}