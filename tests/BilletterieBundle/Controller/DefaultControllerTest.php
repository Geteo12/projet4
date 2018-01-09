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

    public function testCorrectDateVisit(){
        $commande = new Panier();
        $date = "30-07-2017";
        $commande->setDateVisite($date);
        $this->assertEquals($date, $commande->getDate());
    }

    public function testTarifError(){
        $tarif = new Tarif();
        $montant = 16;
        $tarif->setMontant($montant);
        $this->assertEquals($montant, $tarif->getMontant());
    }
}
