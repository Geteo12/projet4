<?php

namespace Billetterie\BilletterieBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PanierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PanierRepository extends EntityRepository
{
    public function prochainIDPanier ()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('max(a.id)');

        return $qb  ->getQuery()
            ->getSingleScalarResult();

    }
    public function codeReservation ()
    {
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890&éèçà=*-+';
        $motDePasse = str_shuffle($char);
        $motDePasse = substr($motDePasse,0,20);

        return $motDePasse;
    }

    public function recupPanierCourant ($em , $id)
    {
        $panierCourant = $em->getRepository('BilletterieBundle:Panier')->findOneBy(array("id" => $id));

        return $panierCourant;
    }

    public function getPlaceReservation ($panier)
    {
        $monPanier = $this->em->getRepository('BilletterieBundle:Panier')->recupPanierCourant($this->em, $panier);

        return $monPanier;
    }

}
