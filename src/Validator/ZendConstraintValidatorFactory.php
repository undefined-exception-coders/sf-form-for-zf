<?php

namespace UEC\SymfonyFormForZendFramework\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use UEC\SymfonyFormForZendFramework\PluginManager\ConstraintPluginManager;

class ZendConstraintValidatorFactory implements ConstraintValidatorFactoryInterface
{
    /**
     * @var array
     */
    private $validators;

    /**
     * @var ConstraintPluginManager
     */
    private $constraintPluginManager;

    /**
     * ZendConstraintValidatorFactory constructor.
     *
     * @param ConstraintPluginManager $constraintPluginManager
     */
    public function __construct(ConstraintPluginManager $constraintPluginManager)
    {
        $this->validators = [];
        $this->constraintPluginManager = $constraintPluginManager;
    }

    /**
     * @inheritDoc
     */
    public function getInstance(Constraint $constraint)
    {
        $className = $constraint->validatedBy();

        if (!isset($this->validators[$className])) {
            if ($this->constraintPluginManager->has($className)) {
                $this->validators[$className] = $this->constraintPluginManager->get($className);
            } elseif (class_exists($className)) {
                $this->validators[$className] = new $className();
            } else {
                throw new \Exception(sprintf('Validator %s not found', $className));
            }
        }

        return $this->validators[$className];
    }
}