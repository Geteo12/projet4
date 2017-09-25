<?php

namespace Billetterie\BilletterieBundle\Controller;

use Billetterie\BilletterieBundle\Entity\panier;
use Billetterie\BilletterieBundle\Form\panierType;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Billetterie\BilletterieBundle\Form\clientType;
use Billetterie\BilletterieBundle\Entity\client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Null;

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

            if($compteur != Null)
            {
                if($compteur >= 1000)
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

            if ($request->isMethod('POST') && $formClient->handleRequest($request)->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $panier = $em->getRepository('BilletterieBundle:panier')->find($session->get('name'));
                $client ->setPanier($panier);

                $em->persist($client);
                $em->flush();

                return $this->redirectToRoute('billetterie_homepage', array('id' => $session->get('name')));
            }

        return $this->render('BilletterieBundle:Default:reservation.html.twig', array('formClient' => $formClient->createView(),
                                                                                            'id' => $session->get('name')
                                                                                            , 'nbClient'=>$nbClient));
    }


}
