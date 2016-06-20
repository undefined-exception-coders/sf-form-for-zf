<?php

namespace UEC\SymfonyFormForZendFramework\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SubclassOfValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) {
            return;
        }

        if (is_subclass_of($value, $constraint->class_name)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ type }}', $constraint->class_name)
            ->addViolation();
    }
}