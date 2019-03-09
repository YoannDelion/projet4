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

        $date = $value->format('d-m');
        $weekDay = date('l', $value->getTimestamp());
        $closed = [
            '01-05',
            '01-11',
            '25-12'
        ];
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
