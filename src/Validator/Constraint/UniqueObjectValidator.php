<?php

namespace UEC\SymfonyFormForZendFramework\Validator\Constraint;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueObjectValidator extends ConstraintValidator
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

        $fields = is_array($constraint->fields)
            ? $constraint->fields
            : (array)$constraint->fields;

        if (is_array($value)) {
            if (null === $constraint->repository_class) {
                throw new \Exception('You must set the repository_class');
            }
            $repositoryClass = $constraint->repository_class;
            $valuesToSearch = $this->getValueFromArray($value, $fields);
        } else {
            $repositoryClass = get_class($value);
            $valuesToSearch = $this->getValueFromObject($value, $fields);
        }

        $tableAlias = 'o';
        $qb = $this->em->createQueryBuilder()
            ->select('COUNT('.$tableAlias.')')
            ->from($repositoryClass, $tableAlias);

        foreach ($valuesToSearch as $f => $v) {
            $qb->andWhere($tableAlias.'.'.$f.' = :'.$f);
            $qb->setParameter($f, $v);
        }

        if (is_callable($constraint->criteria)) {
            call_user_func_array($constraint->criteria, [$qb, $value, $tableAlias]);
        }

        if ($qb->getQuery()->getSingleScalarResult() > 0) {
            $violation = $this->context->buildViolation($constraint->message);
            if (null !== $constraint->error_mapping) {
                $violation->atPath($constraint->error_mapping);
            }
            $violation->addViolation();
        }
    }

    private function getValueFromObject($object, array $fields)
    {
        $values = [];

        foreach ($fields as $field) {
            $method = 'get'.ucfirst($field);
            if (method_exists($object, $method)) {
                $values[$field] = $object->$method();
            }
        }

        return $values;
    }

    private function getValueFromArray($data, array $fields)
    {
        $values = [];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $values[$field] = $data[$field];
            }
        }

        return $values;
    }
}