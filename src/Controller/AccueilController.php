<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     */
    public function index(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->objectManager->persist($reservation);
            $this->objectManager->flush();
            $this->addFlash('success', 'Votre réservation a bien été enregistrée ! Vous allez recevoir un mail de confirmation.');
            return $this->redirectToRoute('accueil');
        }
        return $this->render('accueil/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
