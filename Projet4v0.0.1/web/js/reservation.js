boutonValide = document.querySelector("#billetterie_billetteriebundle_acheteur_enregistrer");

function montantTotal ()
{
  montant = document.querySelectorAll("[id^=montant_billet]");
  totalMontant = document.querySelector("#total_montant_billet");
  var total = 0;

  for(var i = 1; i<=montant.length; i++)
  {
      prix = parseInt(document.querySelector("#montant_billet"+i).textContent);
      total = parseInt(total) + prix;
  }
  totalMontant.textContent = total;
}


document.onload = montantTotal();

