<?php

namespace App\Controller;

use App\Entity\RequestStatus;
use App\Entity\Reservation;
use App\Service\CalculTarif;
use App\Service\StripeService;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @var CalculTarif
     */
    private $calculTarif;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var StripeService
     */
    private $stripeService;

    public function __construct(CalculTarif $calculTarif, ObjectManager $objectManager, StripeService $stripeService)
    {
        $this->calculTarif = $calculTarif;
        $this->objectManager = $objectManager;
        $this->stripeService = $stripeService;
    }

    /**
     * @Route("/reservation", name="reservation")
     * @param Session $session
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Session $session, Request $request)
    {
        if ($session->get('reservation') == null) {
            return $this->redirectToRoute('accueil');
        }
        $reservation = $session->get('reservation');
        $total = $this->calculTarif->calculTarif($reservation);

        if ($request->get('stripeEmail')) {
            $reservation->setMail($request->request->get('stripeEmail'));
            $payment = $this->stripeService->checkPayment($total, $request->get('stripeToken'));
            if ($payment == true) {
                $this->objectManager->persist($reservation);
                $this->objectManager->flush();
                $session->clear();
                $this->addFlash('success', 'Votre paiement a bien été effectué, vous allez recevoir un mail de confirmation.');
                return $this->redirectToRoute('accueil');
            } else {
                $this->addFlash('error', 'Une erreur est survenue, merci de réessayer.');
            }
        }

        $session->set('reservation', $reservation);
        return $this->render('reservation/index.html.twig', [
            'reservation' => $reservation,
            'total' => $total
        ]);
    }
}
