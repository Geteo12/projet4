<?php

namespace Billetterie\BilletterieBundle\Tests\Controller;

use Billetterie\BilletterieBundle\Entity\Client;
use Billetterie\BilletterieBundle\Entity\Panier;
use Billetterie\BilletterieBundle\Entity\Tarif;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    public function testCorrectMail(){
        $commande = new Panier();
        $email = "julien.boulnois12@gmail.com";
        $commande->setMail($email);
        $this->assertEquals($email, $commande->getMail());
    }

    public function testCorrectDateAnniv(){
        $commande = new Client();
        $date = "30-07-2000";
        $commande->setDateNaissance($date);
        $this->assertEquals($date, $commande->getDateNaissance());
    }

    public function testCorrectTarif(){
        $tarif = new Tarif();
        $montant = 16;
        $tarif->setMontant($montant);
        $this->assertEquals($montant, $tarif->getMontant());
    }

    public function testDatePageSuccess()
    {
        $client = self::createClient();
        $session = $client->getContainer()->get('session');
        $session->set('user',1000);
        $session->save();

        $client->request('GET', 'billetterie/date');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}
