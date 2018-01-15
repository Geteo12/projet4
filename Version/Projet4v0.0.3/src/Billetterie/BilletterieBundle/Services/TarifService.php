<?php

namespace Billetterie\BilletterieBundle\Services;


class TarifService
{
    public function tarifBillet ($date, $reduction)
    {
        $billet = 2;

         if($reduction != 0)
         {
             $billet = 4;
         }
         else
         {
        $DateJour = new \DateTime('now');
        $dateInterval = $DateJour->diff($date);
        $age = $dateInterval->format('%y');

        if($age <= 12)
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
        /* }*/

        return $billet;
        }
    }
}