boutonValide = document.querySelector("#billetterie_billetteriebundle_client_enregistrer");
dateNaissance = document.querySelector("#billetterie_billetteriebundle_client_dateNaissance");
boutonValide.addEventListener('click',montantBillet);
boutonValide.addEventListener('click',dateDeNaissance);

function dateDeNaissance (e)
{
   /* numClient = document.querySelector("#nbClient").textContent;
    nombreClient = parseInt(numClient +1);
    montantDuBillet = document.querySelector("#"+numClient);*/

    if (interval.day < 0)
    {
        alert("Date de naissance erronée");
    }
}

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

function montantBillet (e)
{
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Verifie les dates
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    date = document.querySelector("#billetterie_billetteriebundle_client_dateNaissance").value;
    valeurMonth = date.toString().substring(5,7);
    valeurYear = date.toString().substring(0,4);
    valeurDay = date.toString().substring(8,10);

    dateJour = new Date();
    jour = dateJour.getDate();
    mois = dateJour.getMonth()+1;
    annee = dateJour.getFullYear();

    datetimeRecup = new Date(valeurYear+"-"+valeurMonth+"-"+valeurDay);
    datetimeJour = new Date(annee+"-"+mois+"-"+jour);
    interval = dateDiff(datetimeRecup, datetimeJour);

    alert(""+interval.day);

}

function dateDiff(date1, date2){
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;

    tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes

    tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes

    tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures

    tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
    diff.day = tmp;

    return diff;
}


document.onload = montantTotal();

