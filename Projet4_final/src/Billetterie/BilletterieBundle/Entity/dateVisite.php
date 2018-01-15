<?php

namespace Billetterie\BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * dateVisite
 *
 * @ORM\Table(name="date_visite")
 * @ORM\Entity(repositoryClass="Billetterie\BilletterieBundle\Repository\dateVisiteRepository")
 */
class dateVisite
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisite", type="date")
     */
    private $dateVisite;

    /**
     * @var int
     *
     * @ORM\Column(name="compteur", type="integer")
     */
    private $compteur;


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
     * Set dateVisite
     *
     * @param \DateTime $dateVisite
     * @return dateVisite
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime 
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }

    /**
     * Set compteur
     *
     * @param integer $compteur
     * @return dateVisite
     */
    public function setCompteur($compteur)
    {
        $this->compteur = $compteur;

        return $this;
    }

    /**
     * Get compteur
     *
     * @return integer 
     */
    public function getCompteur()
    {
        return $this->compteur;
    }
}
