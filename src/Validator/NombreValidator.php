<?php

namespace App\Validator;

use App\Repository\ReservationRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NombreValidator extends ConstraintValidator
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\Nombre */

        $dateVisite = $this->context->getObject()->getDateVisite();
        $nombreVisite = $this->reservationRepository->getNombreBillets($dateVisite);

        if (($value + $nombreVisite) > 1000) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
