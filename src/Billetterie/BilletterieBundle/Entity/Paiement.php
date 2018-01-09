<?php

namespace Billetterie\BilletterieBundle\Entity;



class Paiement
{

    private $id;
    private $numCarte;
    private $moisExp;
    private $anneeExp;
    private $cvc;
    private $token;

    public function getId()
    {
        return $this->id;
    }

    public function setNumCarte($numCarte)
    {
        $this->numCarte = $numCarte;

        return $this;
    }

    public function getNumCarte()
    {
        return $this->numCarte;
    }

    public function setMoisExp($moisExp)
    {
        $this->moisExp = $moisExp;

        return $this;
    }

    public function getMoisExp()
    {
        return $this->moisExp;
    }

    public function setAnneeExp($anneeExp)
    {
        $this->anneeExp = $anneeExp;

        return $this;
    }

    public function getAnneeExp()
    {
        return $this->anneeExp;
    }

    public function setCvc($cvc)
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getCvc()
    {
        return $this->cvc;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }
}
