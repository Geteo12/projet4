boutonValide = document.querySelector("#billetterie_billetteriebundle_panier_Suivant");
boutonValide.addEventListener('click',testMail);
boutonValide.addEventListener('click',RecupDate);
/*focusDateM = document.querySelector("#billetterie_billetteriebundle_panier_dateVisite_month");
focusDateD = document.querySelector("#billetterie_billetteriebundle_panier_dateVisite_day");
focusDateY = document.querySelector("#billetterie_billetteriebundle_panier_dateVisite_year");
focusDateM.addEventListener('focusout',ajaxCall);
focusDateD.addEventListener('focusout',ajaxCall);
focusDateY.addEventListener('focusout',ajaxCall);*/

function testMail(e)
{
    mail = document.querySelector("#billetterie_billetteriebundle_panier_mail").value;
        if (mail.indexOf("@") == '-1')
        {
            erreurProduite(e);
            alert("email incorrect");
        }
}

function RecupDate (e)
{
    //On récupere les valeurs selectionné par l'utilisateur
    month = document.querySelector("#billetterie_billetteriebundle_panier_date_month");
    day = document.querySelector("#billetterie_billetteriebundle_panier_date_day");
    year = document.querySelector("#billetterie_billetteriebundle_panier_date_year");
    choiceMonth = month.selectedIndex;
    valeurMonth = month.options[choiceMonth].value;
    choiceDay = day.selectedIndex;
    valeurDay = day.options[choiceDay].value;
    choiceYear = year.selectedIndex;
    valeurYear = year.options[choiceYear].value;

    laDate = new Date();
    laDate.setMonth(valeurMonth);
    laDate.setYear(valeurYear);
    laDate.setDate(valeurDay);

    // récupere le jour de la semaine
    dateChoisie = parseInt(laDate.getDay());

    verifJourCorrect(e);


}

/*function ajaxCall(date)
{
    alert("2");
    var places = $('#places');
    $.ajax(
        {
            url: "{{ path('date_reservation') }}",
            method: "post",
            data: {date: date}
        }).done(function(msg)
            {
                alert("date : " + date);
                alert("valeur : " +valeurSelection);
                refresh();
                function refresh ()
                {
                    places.innerHTML ="";
                    $.each(JSON.parse(msg['data']), function (i, item){
                        var li = document.createElement('li');
                        var text = document.createTextNode(item.compteur);
                        alert("item : "+item.compteur.toString());
                        li.appendChild(text);
                        places.appendChild(li);
                    });

                }

            });
}*/

function verifJourCorrect (e)
{
    // si le jour choisi est un dimanche ou un mardi :
    if(dateChoisie == 6)
    {
        erreurProduite(e);
        alert('impossible de réserver pour le dimanche');
    }
    else if(dateChoisie == 2)
    {
        erreurProduite(e);
        alert('le musée est fermé le mardi.');
    }
    else
    {
        // on ajoute un zero devant le numéro du mois et jour
        if (valeurMonth.length == 1)
        {
            valeurMonth = "0"+valeurMonth;
        }
        if (valeurDay.length == 1)
        {
            valeurDay = "0"+valeurDay;
        }

        valeurSelection = valeurYear+""+valeurMonth+""+valeurDay;
        valeurSelection = parseInt(valeurSelection);

       // ajaxCall(valeurSelection);

        verifJourFerie(e);
    }
}
function verifJourFerie (e)
{
    switch (valeurSelection.toString().substring(4,8))
    {
        case '0101' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0417' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0501' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0508' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0525' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0605' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0714' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '0815' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '1101' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '1111' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        case '1225' :
            erreurProduite(e);
            alert("Impossible de choisir un jour ferié");
            break;
        default :
            verifDateJour(e);
    }
}
function verifDateJour (e)
{
    dateJour = new Date();
    jour = dateJour.getDate();
    mois = dateJour.getMonth();
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
            alert("la date selectionnée est passée");
            selectType = document.querySelector("#billetterie_billetteriebundle_panier_Type");
            choiceType = selectType.selectedIndex;
            valeurType = selectType.options[choiceType].value;

            alert(valeurType);
        }
    alert(valeurSelection +" "+ dateDuJour);
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
                  alert("Vous ne pouvez pas choisir un billet à la journée aujourd'hui puisqu'il est plus de 14h");
              }
            }
        }
}

function erreurProduite (e)
{
    e.preventDefault();
}





