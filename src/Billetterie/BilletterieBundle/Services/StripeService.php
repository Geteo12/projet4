<?php

namespace Billetterie\BilletterieBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Billetterie\BilletterieBundle\Entity\DateVisite;


class StripeService
{
    private $em;
    private $router;
    private $session;
    private $mail;

    public function __construct (EntityManager $em, RouterInterface $router, Session $session, MailService $mail)
    {
        $this->em = $em;
        $this->router = $router;
        $this->session = $session;
        $this->mail = $mail;
    }

    public function getStripeService($paiement, $panier)
    {
        $result = true;
        try
        {
            \Stripe\Stripe::setApiKey('sk_test_z0VzceD6uZUemUMwa1FCSjup');

            $token = \Stripe\Token::create(array(
                "card" => array(
                    "number" => $paiement->getNumCarte(),
                    "exp_month" => $paiement->getMoisExp(),
                    "exp_year" => $paiement->getAnneeExp(),
                    "cvc" => $paiement->getCvc()
                )));

            $charge = \Stripe\Charge::create(array(
                'amount' => $panier*100,
                'currency' => 'eur',
                'source' => $token->id
            ));
        }
        catch(\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function getVerifStripe ($nbClient)
    {
        $dateJour = new \DateTime("now");
        //on recupere les clients
        $idPanier = $this->em->getRepository('BilletterieBundle:Panier')->find($this->session->get('name'));
        $panier = $this->em->getRepository('BilletterieBundle:Panier')->recupPanierCourant ($this->em , $idPanier->getId());
        $listeClient = $this->em->getRepository('BilletterieBundle:Client')->RecupClients($idPanier->getId(), $this->em);

        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
        $codeBillet = str_shuffle($char);
        $codeBillet = substr($codeBillet,0,30);
        $panier->setDateEnvoiBillet($dateJour);
        $panier ->setCode($codeBillet);
        $compteur = $this->em->getRepository('BilletterieBundle:DateVisite')->recupDateDuCompteur($idPanier->getDate());

        if($compteur != Null)
        {
            $compteur->setCompteur($compteur->getCompteur() + $nbClient);
            $this->em->persist($compteur);
        }
        else
        {
            $compteur = new DateVisite();
            $compteur->setDateVisite($idPanier->getDate());
            $compteur->setCompteur($nbClient);
            $this->em->persist($compteur);
        }
        $this->em->persist($panier);
        $this->em->flush();

        return array ($panier , $listeClient);
    }
}