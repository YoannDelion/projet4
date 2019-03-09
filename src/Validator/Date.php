<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Date extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $museumClosed = 'Le musée est fermé à la date sélectionnée.';
    public $sunday = 'Vous ne pouvez pas réserver de billet pour les dimanches.';
    public $passedDay = 'Vous ne pouvez pas réserver de billet pour un jour déjà passé.';

}
