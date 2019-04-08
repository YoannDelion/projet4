<?php

namespace App\Service;

use App\Entity\Reservation;

class CalculTarif
{
    /**
     * @param Reservation $reservation
     * @return int
     * @throws \Exception
     */
    public function calculTarif(Reservation $reservation)
    {
        $tarifTotal = 0;

        foreach ($reservation->getBillets() as $billet) {
            $age = $billet->getDateNaissance()->diff(new \DateTime())->format('%Y');
            $reduction = $billet->getReduction();

            $tarif = 0;

            if ($age > 4) {
                if ($age < 12) {
                    $tarif = 8;
                } elseif ($reduction === true) {
                    $tarif = 10;
                } elseif ($age > 60) {
                    $tarif = 12;
                } else {
                    $tarif = 16;
                }
            }
            $billet->setTarif($tarif);
            $tarifTotal += $tarif;
        }

        return $tarifTotal;
    }
}