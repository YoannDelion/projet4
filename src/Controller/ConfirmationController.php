<?php

namespace App\Controller;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function index(Session $session)
    {
        if ($session->get('reservation') == null || !($session->get('paiement') === true)) {
            return $this->redirectToRoute('accueil');
        }

        $reservation = $session->get('reservation');

        $session->clear();

        return $this->render('confirmation/index.html.twig', [
            'reservation' => $reservation
        ]);
    }
}
