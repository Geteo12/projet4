boutonValide = document.querySelector("#billetterie_billetteriebundle_panier_Suivant");
boutonValide.addEventListener('click',testMail);
boutonValide.addEventListener('click',RecupDate);

var pErreur = document.getElementById('pErreur');

function testMail(e)
{
    mail = document.querySelector("#billetterie_billetteriebundle_panier_mail").value;

        if (mail.indexOf("@") == '-1')
        {
            erreurProduite(e);
            pErreur.textContent = "email incorrect";
        }
}

function RecupDate (e)
{
    //On récupere les valeurs selectionné par l'utilisateur
    date = document.querySelector("#billetterie_billetteriebundle_panier_date").value;

    valeurMonth = date.toString().substring(5,7);
    valeurYear = date.toString().substring(0,4);
    valeurDay = date.toString().substring(8,10);

    laDate = new Date();
    laDate.setMonth(valeurMonth);
    laDate.setYear(valeurYear);
    laDate.setDate(valeurDay);

    // récupere le jour de la semaine
    dateChoisie = parseInt(laDate.getDay());

    verifJourCorrect(e);
}

function verifJourCorrect (e)
{
    // si le jour choisi est un dimanche ou un mardi :
    if(dateChoisie == 3)
    {
        erreurProduite(e);
        pErreur.textContent = "impossible de réserver pour le dimanche";
    }
    else if(dateChoisie == 5)
    {
        erreurProduite(e);
        pErreur.textContent = "le musée est fermé le mardi.";
    }
    else
    {
        // on ajoute un zero devant le numéro du mois et jour
        if (valeurMonth.length === 1)
        {
            valeurMonth = "0"+valeurMonth;
        }
        if (valeurDay.length === 1)
        {
            valeurDay = "0"+valeurDay;
        }

        valeurSelection = valeurYear+""+valeurMonth+""+valeurDay;
        valeurSelection = parseInt(valeurSelection);

        verifJourFerie(e);
    }
}
function verifJourFerie (e)
{
    switch (valeurSelection.toString().substring(4,8))
    {
        case '0101' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0417' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0501' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0508' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0525' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0605' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0714' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '0815' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '1101' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '1111' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        case '1225' :
            erreurProduite(e);
            pErreur.textContent = "Impossible de choisir un jour ferié";
            break;
        default :
            verifDateJour(e);
    }
}
function verifDateJour (e)
{
    dateJour = new Date();
    jour = dateJour.getDate();
    mois = dateJour.getMonth()+1; //+1 car la methode ramene le mois precedent au lieu du mois en cours
    annee = dateJour.getFullYear();
    heure  = dateJour.getHours();

        // on ajoute un zero devant le numéro du mois et jour
        if (mois.toString().length == 1)
        {
            mois = "0"+mois;
        }
        if (jour.toString().length == 1)
        {
            jour = "0"+jour;
        }

    dateDuJour = annee+""+mois+""+jour;
    dateDuJour = parseInt(dateDuJour);

        //Si la date est passée
        if (valeurSelection < dateDuJour)
        {
            erreurProduite(e);
            pErreur.textContent = "la date selectionnée est passée";
            selectType = document.querySelector("#billetterie_billetteriebundle_panier_Type");
            choiceType = selectType.selectedIndex;
            valeurType = selectType.options[choiceType].value;

        }
        //si la date est le jour même et qu'il est 14h minimum
        if (valeurSelection == dateDuJour)
        {
            if(heure >= 14)
            {
                selectType = document.querySelector("#billetterie_billetteriebundle_panier_Type");
                choiceType = selectType.selectedIndex;
                valeurType = selectType.options[choiceType].value;

              if (valeurType == "1")
              {
                  erreurProduite(e);
                  pErreur.textContent = "Vous ne pouvez pas choisir un billet à la journée aujourd'hui puisqu'il est plus de 14h";
              }
            }
        }
}

function erreurProduite (e)
{
    e.preventDefault();
}





