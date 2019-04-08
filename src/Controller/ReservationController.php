<?php

namespace App\Controller;

use App\Service\CalculTarif;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @var CalculTarif
     */
    private $calculTarif;

    public function __construct(CalculTarif $calculTarif)
    {
        $this->calculTarif = $calculTarif;
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(Session $session)
    {
        $reservation =  $session->get('reservation');

        dump($reservation);

        dump($this->calculTarif->calculTarif($reservation));

        dump($reservation);


        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
}
