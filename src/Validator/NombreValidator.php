<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\BilletRepository;

class NombreValidator extends ConstraintValidator
{
    private $billetRepository;

    public function __construct(BilletRepository $billetRepository)
    {
        $this->billetRepository = $billetRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\Nombre */

        $dateVisite = $this->context->getObject()->getDateVisite();
        $nombreVisite = $this->billetRepository->getNombreBillets($dateVisite);

        if (($value + $nombreVisite) > 1000) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
