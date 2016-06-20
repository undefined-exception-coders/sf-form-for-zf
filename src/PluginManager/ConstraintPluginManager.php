<?php

namespace UEC\SymfonyFormForZendFramework\PluginManager;

use Symfony\Component\Validator\ConstraintValidatorInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class ConstraintPluginManager extends AbstractPluginManager
{
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof ConstraintValidatorInterface) {
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugins managed by "%s" must implement "%s". "%s" provided',
            __CLASS__,
            ConstraintValidatorInterface::class,
            is_object($plugin) ? get_class($plugin) : gettype($plugin)
        ));
    }
}