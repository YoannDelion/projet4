<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\Date */

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $dateReservation = $this->context->getObject()->getDateReservation()->setTime(00, 00);;
        $dateVisite = $value->setTime(00, 00);;

        $date = $value->format('d-m');
        $weekDay = date('l', $value->getTimestamp());
        $closed = [
            '01-05',
            '01-11',
            '25-12'
        ];

        if ($dateReservation > $dateVisite) {
            $this->context->buildViolation($constraint->passedDay)
                ->addViolation();
        }

        if ($weekDay === 'Sunday') {
            $this->context->buildViolation($constraint->sunday)
                ->addViolation();
        }

        if ($weekDay === "Tuesday" || in_array($date, $closed)) {
            $this->context->buildViolation($constraint->museumClosed)
                ->addViolation();
        }
    }
}
