<?php

namespace App\Tests;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class ConfirmationControllerTest extends WebTestCase
{
    public function testPageConfirmation()
    {
        $session = new Session(new MockFileSessionStorage());
        $session->set('reservation', new Reservation());
        $session->set('paiement', true);

        $client = static::createClient();
        $client->getContainer()->set('session', $session);

        $crawler = $client->request('GET', '/confirmation');

        $this->assertSame(1, $crawler->filter('html:contains("Confirmation de réservation")')->count());
    }

    public function testPageConfirmationRedirection()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/confirmation');
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Musée du Louvres")')->count());
    }
}
