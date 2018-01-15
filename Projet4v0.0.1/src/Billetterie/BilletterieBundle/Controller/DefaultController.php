<?php

namespace Billetterie\BilletterieBundle\Controller;

use Billetterie\BilletterieBundle\Entity\panier;
use Billetterie\BilletterieBundle\Form\panierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Billetterie\BilletterieBundle\Form\clientType;
use Billetterie\BilletterieBundle\Entity\client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function choixDateAction (Request $request)
    {
        $panier = new panier();
        $formPanier = $this->get('form.factory')->create(panierType::class, $panier);

       /* if($request->isXmlHttpRequest())
        {
            $date =  $request->get('date');
            $conn = $this->get('database_connection');
            $query = "select date.compteur from date where date.date = ". $_POST["valeurSelection"];
            $row = $conn->fetchAll($query);

            return new JsonResponse(array('data' => json_encode($row)));
        }*/


        if ($request->isMethod('POST') && $formPanier->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush();

            $idPanier = $em->getRepository('BilletterieBundle:panier')->prochainIDPanier();
            $session = $request->getSession();
            $session->set('name', $idPanier);


            return $this->redirectToRoute('billetterie_homepage', array('id' => $session->get('name')));
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
