<?php

namespace UEC\SymfonyFormForZendFramework\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class SubclassOf extends Constraint
{
    public $class_name;

    public function getRequiredOptions()
    {
        return ['class_name'];
    }

    public $message = 'This value should be of type {{ type }}.';
}