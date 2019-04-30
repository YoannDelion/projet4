<?php

namespace App\Tests;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class ReservationControllerTest extends WebTestCase
{
    public function testPageReservationRedirection()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/reservation');
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Musée du Louvres")')->count());
    }

    public function testPageReservation()
    {
        $session = new Session(new MockFileSessionStorage());
        $session->set('reservation', new Reservation());

        $client = static::createClient();
        $client->getContainer()->set('session', $session);

        $crawler = $client->request('GET', '/reservation');

        $this->assertSame(1, $crawler->filter('html:contains("Réservation")')->count());
    }

}
