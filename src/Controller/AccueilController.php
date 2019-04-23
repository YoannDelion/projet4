<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @var ReservationRepository
     */
    private $reservationRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ReservationRepository $reservationRepository, ObjectManager $objectManager)
    {
        $this->reservationRepository = $reservationRepository;
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/", name="accueil")
     * @param Request $request
     * @param Session $session
     * @return RedirectResponse|Response
     */
    public function index(Request $request, Session $session)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session->set('reservation', $reservation);

            return $this->redirectToRoute('reservation');
        }
        return $this->render('accueil/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
