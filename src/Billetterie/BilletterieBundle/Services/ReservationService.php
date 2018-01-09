<?php

namespace Billetterie\BilletterieBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;

class ReservationService
{
    private $em;
    private $router;
    private $session;
    private $tarifService;

    public function __construct (EntityManager $em, RouterInterface $router, Session $session, TarifService $tarifService)
    {
        $this->em = $em;
        $this->router = $router;
        $this->session = $session;
        $this->tarifService = $tarifService;
    }

    public function getReservation ($dateService, $client, $nbClient, $tarifReduit)
    {
        $dateClient = new \DateTime($dateService);
        $billet = $this->tarifService->tarifBillet($dateClient, $tarifReduit);
        $billetClient = $this->em->getRepository('BilletterieBundle:Tarif')->find($billet);
        $panier = $this->em->getRepository('BilletterieBundle:Panier')->find($this->session->get('name'));
        $client ->setPanier($panier);
        $client ->setTarif($billetClient);
        $this->em->persist($client);
        $this->em->flush();
        $MontantTotalBilletsBDD = $this->em->getRepository('BilletterieBundle:Client')->recupMontantTotalBillet($panier, $this->em);
        $panier ->setMontant($MontantTotalBilletsBDD);
        $panier ->setNbreEntrees($nbClient+1);
        $this->em->persist($panier);
        $this->em->flush();
    }
}