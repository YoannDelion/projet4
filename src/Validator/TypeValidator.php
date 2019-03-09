<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\Type */

        $dateReservation = $this->context->getObject()->getDateReservation();
        $dateVisite = $this->context->getObject()->getDateVisite();
        $dateVisite->setTime(14, 00);

        if ($value === 0) { //Si type = journée
            if ($dateReservation->format('d-m-Y') == $dateVisite->format('d-m-Y')) {
                if ($dateReservation > $dateVisite) {
                    $this->context->buildViolation($constraint->message)
                        ->addViolation();
                }
            }
        }
    }
}
