<?php

namespace Billetterie\BilletterieBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * dateVisiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class dateVisiteRepository extends EntityRepository
{
    public function recupCompteurDate ($dateVisite)
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d.compteur')
            ->where('d.dateVisite = :dateVisite')
            ->setParameter('dateVisite', $dateVisite);

        return $qb  ->getQuery()
                    ->getOneOrNullResult();

    }

}
