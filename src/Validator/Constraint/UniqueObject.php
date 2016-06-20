<?php

namespace UEC\SymfonyFormForZendFramework\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class UniqueObject extends Constraint
{
    public $fields = [];
    public $error_mapping;
    public $repository_class;
    public $criteria;

    public function getRequiredOptions()
    {
        return ['fields'];
    }

    public $message = 'This object already exists.';

    public function validatedBy()
    {
        return UniqueObjectValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}