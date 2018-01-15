<?php

namespace Billetterie\BilletterieBundle\Services;


class TarifService
{
    // recupere l'id du montant du billet
    public function tarifBillet ($date, $reduction)
    {
        $billet = 2;
        $DateJour = new \DateTime('now');
        $dateInterval = $DateJour->diff($date);
        $age = $dateInterval->format('%y');

         if($reduction == 1)
         {
             if ($age < 4)
             {
                 $billet = 5;
             }
             else
             {
                 $billet = 4;
             }
         }
         else
         {
            if ($age < 4)
            {
                $billet = 5;
            }
            else if($age <= 12)
            {
                $billet = 1;
            }
            else if($age < 60)
            {
                $billet = 2;
            }
            else
            {
                $billet = 3;
            }
         }
        return $billet;
    }
}