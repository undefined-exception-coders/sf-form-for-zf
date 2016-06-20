<?php

namespace UEC\SymfonyFormForZendFramework\Validator\Constraint;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UniqueObjectValidator constructor.
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        $qb = $this->em->createQueryBuilder()
            ->select('COUNT(o)')
            ->from($constraint->repository_class, 'o')
            ->andWhere('o.'.$constraint->repository_field.' = :'.$constraint->repository_field)
            ->setParameter($constraint->repository_field, $value);

        if (is_callable($constraint->criteria)) {
            call_user_func_array($constraint->criteria, [$qb, $value]);
        }

        if ($qb->getQuery()->getSingleScalarResult() > 0) {
            $violation = $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}