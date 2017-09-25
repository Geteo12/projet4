<?php

class testUnit
{
    public function testCorrectMail(){
        $commande = new panier();
        $email = "julien.boulnois12@gmail.com";
        $commande->setMail($email);
        $this->assertEquals($email, $commande->getMail());
    }

    public function testCorrectDateAnniv(){
        $commande = new client();
        $date = "30-07-2000";
        $commande->setDateNaissance($date);
        $this->assertEquals($date, $commande->getDateNaissance());
    }

    public function testCorrectDateVisit(){
        $commande = new panier();
        $date = "30-07-2017";
        $commande->setDateVisite($date);
        $this->assertEquals($date, $commande->getDate());
    }
}