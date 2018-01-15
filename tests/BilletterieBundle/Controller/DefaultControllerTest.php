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

    public function testCorrectTarif(){
        $tarif = new Tarif();
        $montant = 16;
        $tarif->setMontant($montant);
        $this->assertEquals($montant, $tarif->getMontant());
    }

    public function testReservationActionDonneesValides()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'billetterie/date');

        $form = $crawler->selectButton('Suivant')->form();

                $form['$formPanier[\'date\']']      = '22/10/2018';
                $form['$formPanier[\'Type\']'] 		= '1';
                $form['$formPanier[\'mail\']']      = 'julien.boulnois12@gmail.com';


        $client->submit($form);

          $crawler = $client->followRedirect();

          $form = $crawler->selectButton('submit')->form();
          $values = $form->getPhpValues();


          $values['form']['formClient'][0]['dateNaissance']        = '18/10/2000';
          $values['form']['formClient'][0]['nom'] 		            ='Hennroule';
          $values['form']['formClient'][0]['prenom']               = 'Franck';
          $values['form']['formClient'][0]['pays'] 		        = 'Suisse';

          $crawler = $client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());
          $crawler = $client->followRedirect();
          $link = $crawler->selectLink('submit')->link();
          $crawler = $client->click($link);

        $this->assertContains("Les données sont correctes", $client->getResponse()->getContent());
    }

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', 'billetterie/date');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
