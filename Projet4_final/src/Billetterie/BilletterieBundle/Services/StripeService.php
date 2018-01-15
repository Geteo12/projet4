<?php

namespace Billetterie\BilletterieBundle\Services;


class StripeService
{
    public function getStripeService($paiement, $panier)
    {
        $result = true;
       // $mntPanier = $panier->getMontant();
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
}