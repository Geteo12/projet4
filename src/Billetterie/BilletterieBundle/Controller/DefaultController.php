<?php

namespace Billetterie\BilletterieBundle\Controller;

use Billetterie\BilletterieBundle\Entity\Paiement;
use Billetterie\BilletterieBundle\Entity\Panier;
use Billetterie\BilletterieBundle\Form\PaiementType;
use Billetterie\BilletterieBundle\Form\PanierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Billetterie\BilletterieBundle\Form\ClientType;
use Billetterie\BilletterieBundle\Entity\Client;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

    public function choixDateAction (Request $request)
    {
            $panier = new Panier();
            $formPanier = $this->get('form.factory')->create(PanierType::class, $panier);
            $resultat ="";
            if ($request->isMethod('POST') && $formPanier->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $form = $request->request->get('billetterie_billetteriebundle_panier');
                $dateService = $this->container->get('date_choisie_service');
                $dateService -> getValeurDateChoisieService(substr($form['date'],5,2), substr($form['date'],0,4), substr($form['date'],8,2));
                $compteur = $em->getRepository('BilletterieBundle:DateVisite')->recupCompteurDate($dateService -> getValeurDateChoisieService(substr($form['date'],5,2), substr($form['date'],0,4), substr($form['date'],8,2)));
                $dateService -> getJourComplet();
                $dateService ->getPlacesDispoBool($compteur);

                if ($dateService ->getPlacesDispoBool($compteur) == false)
                {
                    return $this->render('BilletterieBundle:Default:dateReservation.html.twig', array('formPanier' => $formPanier->createView(), 'resultat' =>$dateService -> getJourComplet()));
                }
                else{
                    return $dateService->getPlacesDispo($compteur,$panier,$request);
                }
            }
        return $this->render('BilletterieBundle:Default:dateReservation.html.twig', array('formPanier' => $formPanier->createView(), 'resultat' =>$resultat));
    }

    public function reservationAction(Request $request)
    {
       $client = new Client();
       $formClient = $this->get('form.factory')->create(ClientType::class, $client);
       $espaces = '  ';
       $session = $request -> getSession();
       $em = $this->getDoctrine()->getManager();
       $panier = $session->get('name');
       $nbClient = $em->getRepository('BilletterieBundle:Client')->recupNbrClient($panier);
       $MontantTotalBillets = $em->getRepository('BilletterieBundle:Client')->recupMontantTotalBillet($panier, $em);
       $MontantBilletParClient = $em->getRepository('BilletterieBundle:Client')->RecupMontantBilletParClient($panier, $em);
       $monPanier = $em->getRepository('BilletterieBundle:Panier')->recupPanierCourant($em, $panier);
       $compteur = $em->getRepository('BilletterieBundle:DateVisite')->recupCompteurDate($monPanier->getDate());
        $resultat = "";
            if ($request->isMethod('POST') && $formClient->handleRequest($request)->isValid())
            {
                $total = $compteur['compteur']+$nbClient;
                if($total < 1000)
                {
                    $form = $request->request->get('billetterie_billetteriebundle_client');
                    $dateService = $this->container->get('date_choisie_service');
                    if(isset($formTarifReduit)) {
                        $tarifReduit = 1;
                    } else {$tarifReduit = 0;}
                    $reservationService = $this->container->get('reservation_service');
                    $reservationService -> getReservation($dateService -> getValeurDateChoisieService(substr($form['dateNaissance'],5,2), substr($form['dateNaissance'],0,4), substr($form['dateNaissance'],8,2)), $client, $nbClient, $tarifReduit);
                    return $this->redirectToRoute('billetterie_homepage');
                }
                else
                {
                    $resultat = "Le nombre total de vente de billet pour ce jour est atteint";
                    return $this->render('BilletterieBundle:Default:reservation.html.twig', array('formClient' => $formClient->createView(), 'id' => $session->get('name'), 'nbClient'=>$nbClient , 'tarifTotalBillet' => $MontantTotalBillets, 'tarifDuBillet' =>$MontantBilletParClient,'espaces' =>$espaces, 'resultat'=>$resultat));
                }
            }
        return $this->render('BilletterieBundle:Default:reservation.html.twig', array('formClient' => $formClient->createView(), 'id' => $session->get('name'), 'nbClient'=>$nbClient , 'tarifTotalBillet' => $MontantTotalBillets, 'tarifDuBillet' =>$MontantBilletParClient,'espaces' =>$espaces, 'resultat'=>$resultat));
    }

    public function prepareAction(Request $request)
    {
        $paiement = new Paiement();
        $formPaiement = $this->get('form.factory')->create(PaiementType::class, $paiement);
        $session = $request -> getSession();
        $em = $this->getDoctrine()->getManager();
        $idPanier =  $session->get('name');
        $MontantTotalBillets = $em->getRepository('BilletterieBundle:Client')->recupMontantTotalBillet($idPanier, $em);
        $panierID =  $session->get('name');
        $nbClient = $em->getRepository('BilletterieBundle:Client')->recupNbrClient($panierID);
        if ($request->isMethod('POST') && $formPaiement->handleRequest($request)->isValid())
        {
            $stripeService = $this->container->get('stripe_service');
            if($stripeService->getStripeService($paiement, $MontantTotalBillets) == false)
            {
                $request->getSession()->getFlashBag()->add('ERREUR', 'Transaction échouée, veuillez vérifier vos données bancaires');
            }
            else
            {
                $stripeService->getVerifStripe($nbClient);
                $panier = $stripeService->getVerifStripe($nbClient)[0];
                $listeClient = $stripeService->getVerifStripe($nbClient)[1];
                $emailBody = $this->renderView('BilletterieBundle:Default:bodyMail.html.twig',array(
                    'clients' => $listeClient,
                    'logo' => 'toto', 'type' => $panier->getType(), 'total' => $panier->getMontant(), 'dateReservation' => $panier->getDate(), 'code' => $panier->getCode(), 'nbClient' => $nbClient
                ));
                $mailerService = $this->container->get('mail_service');
                $mailerService->getMailService($emailBody, $panier);
                return $this->redirectToRoute('remerciement');
            }
        }
        return $this->render('BilletterieBundle:Default:prepare.html.twig', array('formPaiement' => $formPaiement->createView(),
                                                                                        'id' => $session->get('name')
                                                                                        , 'tarifTotalBillet' => $MontantTotalBillets,
                                                                                        ));
    }

    public function remerciementAction ()
    {
        return $this->render('BilletterieBundle:Default:remerciement.html.twig');
    }

}
