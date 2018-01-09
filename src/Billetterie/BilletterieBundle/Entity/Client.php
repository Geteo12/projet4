<?php

namespace Billetterie\BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="Billetterie\BilletterieBundle\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="nom", type="string", length=150)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=150)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=150)
     */
    private $pays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoiBillet", type="date", nullable=true)
     */
    private $dateEnvoiBillet;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarifReduit", type="boolean", nullable=true)
     */
    private $tarifReduit;

    /**
     * @ORM\ManyToOne(targetEntity="Billetterie\BilletterieBundle\Entity\Panier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $panier;

    /**
     * @ORM\ManyToOne(targetEntity="Billetterie\BilletterieBundle\Entity\Tarif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tarif;


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
     * Set nom
     *
     * @param string $nom
     * @return client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return client
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return client
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateEnvoiBillet
     *
     * @param \DateTime $dateEnvoiBillet
     * @return client
     */
    public function setDateEnvoiBillet($dateEnvoiBillet)
    {
        $this->dateEnvoiBillet = $dateEnvoiBillet;

        return $this;
    }

    /**
     * Get dateEnvoiBillet
     *
     * @return \DateTime 
     */
    public function getDateEnvoiBillet()
    {
        return $this->dateEnvoiBillet;
    }

    /**
     * Set tarifReduit
     *
     * @param boolean $tarifReduit
     * @return client
     */
    public function setTarifReduit($tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;

        return $this;
    }

    /**
     * Get tarifReduit
     *
     * @return boolean 
     */
    public function getTarifReduit()
    {
        return $this->tarifReduit;
    }

    /**
     * Set panier
     *
     * @param \Billetterie\BilletterieBundle\Entity\panier $panier
     * @return client
     */
    public function setPanier(\Billetterie\BilletterieBundle\Entity\panier $panier)
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get panier
     *
     * @return \Billetterie\BilletterieBundle\Entity\panier
     */
    public function getPanier()
    {
        return $this->panier;
    }



    /**
     * Set tarif
     *
     * @param \Billetterie\BilletterieBundle\Entity\tarif $tarif
     * @return client
     */
    public function setTarif(\Billetterie\BilletterieBundle\Entity\tarif $tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return \Billetterie\BilletterieBundle\Entity\tarif 
     */
    public function getTarif()
    {
        return $this->tarif;
    }
}
