<?php

namespace App\Controller;

use App\Entity\RequestStatus;
use App\Service\CalculTarif;
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

    public function __construct(CalculTarif $calculTarif, ObjectManager $objectManager)
    {
        $this->calculTarif = $calculTarif;
        $this->objectManager = $objectManager;
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
        $reservation =  $session->get('reservation');
        $total = $this->calculTarif->calculTarif($reservation);
        $session->set('reservation', $reservation);

        $form = $this->createFormBuilder($reservation)
            ->add('mail', EmailType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //envoie mail
        }

        return $this->render('reservation/index.html.twig', [
            'reservation' => $reservation,
            'total' => $total,
            'form' => $form->createView()
        ]);
    }
}
