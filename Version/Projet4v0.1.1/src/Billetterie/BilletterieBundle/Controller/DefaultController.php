<?php

namespace Billetterie\BilletterieBundle\Controller;

use Billetterie\BilletterieBundle\Entity\dateVisite;
use Billetterie\BilletterieBundle\Entity\paiement;
use Billetterie\BilletterieBundle\Entity\panier;
use Billetterie\BilletterieBundle\Form\paiementType;
use Billetterie\BilletterieBundle\Form\panierType;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Billetterie\BilletterieBundle\Form\clientType;
use Billetterie\BilletterieBundle\Entity\client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Null;
use Billetterie\BilletterieBundle\Services\TarifService;

class DefaultController extends Controller
{
    public function choixDateAction (Request $request)
    {
        $panier = new panier();
        $formPanier = $this->get('form.factory')->create(panierType::class, $panier);


        if ($request->isMethod('POST') && $formPanier->handleRequest($request)->isValid())
        {
            //verif 1000 billets
           /* var_dump($request->request->all());
            exit;*/
            $form = $request->request->get('billetterie_billetteriebundle_panier');
            $valeurMonth = substr($form['date'],5,2);
            $valeurYear = substr($form['date'],0,4);
            $valeurDay = substr($form['date'],8,2);
            $dateChoisie = $valeurYear."-".$valeurMonth."-".$valeurDay;

            $em = $this->getDoctrine()->getManager();
            $compteur = $em->getRepository('BilletterieBundle:dateVisite')->recupCompteurDate($dateChoisie);
            $placesMax = 1000;

            if($compteur != Null)
            {
                foreach ($compteur as $compt)
                {
                    if($compt > $placesMax)
                    {
                        echo "Plus de place pour se jour !";  // a refaire propre a la fin

                    }
                    else
                    {
                        $em->persist($panier);
                        $em->flush();
                        $request->request->get('name');
                        $idPanier = $em->getRepository('BilletterieBundle:panier')->prochainIDPanier();
                        $session = $request->getSession();
                        $session->set('name', $idPanier);

                        return $this->redirectToRoute('billetterie_homepage', array('id' => $session->get('name')));
                    }
                }
            }
            else
            {
                $em->persist($panier);
                $em->flush();
                $request->request->get('name');
                $idPanier = $em->getRepository('BilletterieBundle:panier')->prochainIDPanier();
                $session = $request->getSession();
                $session->set('name', $idPanier);

                return $this->redirectToRoute('billetterie_homepage', array('id' => $session->get('name')));
            }
        }

        return $this->render('BilletterieBundle:Default:dateReservation.html.twig', array('formPanier' => $formPanier->createView()));

    }

    public function reservationAction(Request $request)
    {
       $client = new client();
       $formClient = $this->get('form.factory')->create(clientType::class, $client);

       $session = $request -> getSession();

       $em = $this->getDoctrine()->getManager();
       $panier =  $session->get('name');
       $nbClient = $em->getRepository('BilletterieBundle:client')->recupNbrClient($panier);
       $tarifBilletClient = $em->getRepository('BilletterieBundle:client')->recupTarifClient($panier);

        $MontantTotalBillets = $em->getRepository('BilletterieBundle:client')->recupMontantTotalBillet($panier, $em);
        $MontantBilletParClient = $em->getRepository('BilletterieBundle:client')->RecupMontantBilletParClient($panier, $em);

            if ($request->isMethod('POST') && $formClient->handleRequest($request)->isValid())
            {
                $form = $request->request->get('billetterie_billetteriebundle_client');
                $valeurMonth = substr($form['dateNaissance'],5,2);
                $valeurYear = substr($form['dateNaissance'],0,4);
                $valeurDay = substr($form['dateNaissance'],8,2);
                $dateChoisie = $valeurYear."-".$valeurMonth."-".$valeurDay;

                if(isset($form['tarifReduit']))
                {
                    $tarifReduit = 1;
                }
                else
                {
                    $tarifReduit = 0;
                }


                $dateClient = new \DateTime($dateChoisie);
                $prixBillet = $this->container->get('tarif_service');
                $billet = $prixBillet->tarifBillet($dateClient, $tarifReduit); // tarifreduit ne fonctionne toujours pas
                $billetClient = $em->getRepository('BilletterieBundle:tarif')->find($billet);

                $em = $this->getDoctrine()->getManager();

                $panier = $em->getRepository('BilletterieBundle:panier')->find($session->get('name'));
                $client ->setPanier($panier);
                $client ->setTarif($billetClient);

                $em->persist($client);
                $em->flush();

                $MontantTotalBilletsBDD = $em->getRepository('BilletterieBundle:client')->recupMontantTotalBillet($panier, $em);
                $panier ->setMontant($MontantTotalBilletsBDD);
                $panier ->setNbreEntrees($nbClient+1);

                $em->persist($panier);
                $em->flush();

                return $this->redirectToRoute('billetterie_homepage', array('id' => $session->get('name')));
            }

        return $this->render('BilletterieBundle:Default:reservation.html.twig', array('formClient' => $formClient->createView(),
                                                                                            'id' => $session->get('name')
                                                                                            , 'nbClient'=>$nbClient , 'tarifTotalBillet' => $MontantTotalBillets,
                                                                                                'tarifDuBillet' =>$MontantBilletParClient));
    }

    public function prepareAction(Request $request)
    {
        $paiement = new paiement();
        $formPaiement = $this->get('form.factory')->create(paiementType::class, $paiement);
        $session = $request -> getSession();
        $em = $this->getDoctrine()->getManager();
        $idPanier =  $session->get('name');
        $MontantTotalBillets = $em->getRepository('BilletterieBundle:client')->recupMontantTotalBillet($idPanier, $em);

        $panierID =  $session->get('name');
        $nbClient = $em->getRepository('BilletterieBundle:client')->recupNbrClient($panierID);

        if ($request->isMethod('POST') && $formPaiement->handleRequest($request)->isValid())
        {
            $stripeService = $this->container->get('stripe_service');

            if($stripeService->getStripeService($paiement, $MontantTotalBillets) == false)
            {
                $request->getSession()->getFlashBag()->add('ERREUR', 'Transaction échouée, veuillez vérifier vos données bancaires');
                echo "erreur";
            }
            else
            {
                echo "aucune erreur";
                $dateJour = new \DateTime("now");
                //on recupere les clients
                $idPanier = $em->getRepository('BilletterieBundle:panier')->find($session->get('name'));
                echo $idPanier->getId();
                $panier = $em->getRepository('BilletterieBundle:panier')->recupPanierCourant ($em , $idPanier->getId());
                //$client ->getPanier($panier);
                $listeClient = $em->getRepository('BilletterieBundle:client')->RecupClients($idPanier->getId(), $em);

                $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
                $codeBillet = str_shuffle($char);
                $codeBillet = substr($codeBillet,0,30);
                $panier->setDateEnvoiBillet($dateJour);
                $panier ->setCode($codeBillet);
                $compteur = $em->getRepository('BilletterieBundle:dateVisite')->recupDateDuCompteur($idPanier->getDate());

                if($compteur != Null)
                {
                    $compteur->setCompteur($compteur->getCompteur() + $nbClient);
                    $em->persist($compteur);
                }
                else
                {
                    $compteur = new dateVisite();
                    $compteur->setDateVisite($idPanier->getDate());
                    $compteur->setCompteur($nbClient);
                    $em->persist($compteur);
                }
                $em->persist($panier);
                $em->flush();

                $emailBody = $this->renderView('BilletterieBundle:Default:bodyMail.html.twig',array(
                    'clients' => $listeClient,
                    'logo' => 'toto', 'type' => $panier->getType(), 'total' => $panier->getMontant(), 'dateReservation' => $panier->getDate(), 'code' => $panier->getCode(), 'nbClient' => $nbClient
                ));

                $mailerService = $this->container->get('mail_service');
                $mailerService->getMailService($emailBody, $panier);
            }

        }

        return $this->render('BilletterieBundle:Default:prepare.html.twig', array('formPaiement' => $formPaiement->createView(),
                                                                                        'id' => $session->get('name')
                                                                                        , 'tarifTotalBillet' => $MontantTotalBillets,
                                                                                        ));
    }

}
