<?php

namespace UEC\SymfonyFormForZendFramework\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class UniqueField extends Constraint
{
    public $repository_class;
    public $repository_field;
    public $criteria;

    public function getRequiredOptions()
    {
        return ['repository_class','repository_field'];
    }

    public $message = 'This field already exists.';

    public function validatedBy()
    {
        return UniqueFieldValidator::class;
    }
}