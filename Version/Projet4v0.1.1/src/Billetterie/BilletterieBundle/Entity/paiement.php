<?php

namespace Billetterie\BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity(repositoryClass="Billetterie\BilletterieBundle\Repository\paiementRepository")
 */
class paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numCarte", type="string")
     */
    private $numCarte;

    /**
     * @var int
     *
     * @ORM\Column(name="moisExp", type="integer")
     */
    private $moisExp;

    /**
     * @var int
     *
     * @ORM\Column(name="anneeExp", type="integer")
     */
    private $anneeExp;

    /**
     * @var int
     *
     * @ORM\Column(name="cvc", type="integer")
     */
    private $cvc;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numCarte
     *
     * @param string $numCarte
     * @return paiement
     */
    public function setNumCarte($numCarte)
    {
        $this->numCarte = $numCarte;

        return $this;
    }

    /**
     * Get numCarte
     *
     * @return string
     */
    public function getNumCarte()
    {
        return $this->numCarte;
    }

    /**
     * Set moisExp
     *
     * @param integer $moisExp
     * @return paiement
     */
    public function setMoisExp($moisExp)
    {
        $this->moisExp = $moisExp;

        return $this;
    }

    /**
     * Get moisExp
     *
     * @return integer 
     */
    public function getMoisExp()
    {
        return $this->moisExp;
    }

    /**
     * Set anneeExp
     *
     * @param integer $anneeExp
     * @return paiement
     */
    public function setAnneeExp($anneeExp)
    {
        $this->anneeExp = $anneeExp;

        return $this;
    }

    /**
     * Get anneeExp
     *
     * @return integer 
     */
    public function getAnneeExp()
    {
        return $this->anneeExp;
    }

    /**
     * Set cvc
     *
     * @param integer $cvc
     * @return paiement
     */
    public function setCvc($cvc)
    {
        $this->cvc = $cvc;

        return $this;
    }

    /**
     * Get cvc
     *
     * @return integer 
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return paiement
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
}
