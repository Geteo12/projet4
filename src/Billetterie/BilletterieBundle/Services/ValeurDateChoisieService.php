<?php

namespace Billetterie\BilletterieBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ValeurDateChoisieService
{
    private $em;
    private $router;
    private $session;

    public function __construct (EntityManager $em, RouterInterface $router, Session $session)
    {
        $this->em = $em;
        $this->router = $router;
        $this->session = $session;
    }

    public function getValeurDateChoisieService($valeurMonth, $valeurYear, $valeurDay)
    {
        $dateChoisie = $valeurYear."-".$valeurMonth."-".$valeurDay;
        return $dateChoisie;
    }

    public function getPlacesDispo ($compteur, $panier, $request)
    {
        $placesMax = 1000;
        if($compteur != Null)
        {
            foreach ($compteur as $compt)
            {
                if($compt > $placesMax)
                {
                    return new RedirectResponse($this->router->generate('date_reservation'));
                }
                else
                {
                    $this->em->persist($panier);
                    $this->em->flush();
                    $request->request->get('name');
                    $idPanier = $this->em->getRepository('BilletterieBundle:Panier')->prochainIDPanier();
                    $this->session = $request->getSession();
                    $this->session->set('name', $idPanier);
                    return new RedirectResponse($this->router->generate('billetterie_homepage'));
                }
            }
        }
        else
        {
            $this->em->persist($panier);
            $this->em->flush();
            $request->request->get('name');
            $idPanier = $this->em->getRepository('BilletterieBundle:Panier')->prochainIDPanier();
            $this->session = $request->getSession();
            $this->session->set('name', $idPanier);
            return new RedirectResponse($this->router->generate('billetterie_homepage'));
        }
    }

    public function getPlacesDispoBool ($compteur)
    {
        $placesMax = 1000;
        $bool = true;
        if($compteur != Null)
        {
            foreach ($compteur as $compt)
            {
                if($compt > $placesMax)
                {
                    $bool = false;
                    return $bool;
                }
                else
                {
                    return $bool;
                }
            }
        }
        else
        {
            return $bool;
        }
    }

    public function getJourComplet ()
    {
            $resultat = "Désolé, le nombre de places total pour ce jour a été atteint";
            return $resultat;
    }
}