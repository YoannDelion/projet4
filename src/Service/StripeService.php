<?php

namespace App\Service;

use App\Entity\Reservation;
use Stripe;

class StripeService
{
    public function checkPayment($total, $token)
    {
        Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

        $charge = Stripe\Charge::create([
            'amount' => $total*100,
            'currency' => 'eur',
            'description' => 'Musée du Louvres',
            'source' => $token,
        ]);

        if ($charge instanceof Stripe\Charge && $charge->paid == true) {
            return true;
        }
        return false;
    }
}