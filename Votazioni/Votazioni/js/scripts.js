function hidShow(admin, user) {
    var amministratore=document.getElementsByClassName("amministratore");
    var utente=document.getElementsByClassName("utente");
    for (var i=0; i<amministratore.length; i++)
        amministratore[i].style.display=admin;
    for (var i=0; i<utente.length; i++)
        utente[i].style.display=user;
}

function showLink(class1, class2) {
    var hide=document.getElementsByClassName(class1);
    for (var i=0; i<hide.length; i++)
        hide[i].style.display = "none";
    var show=document.getElementsByClassName(class2);
    for (var i=0; i<show.length; i++)
        show[i].style.display = "block";
}


function sortTable(n, classN)
    {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table=document.getElementsByClassName("votTable");
    switching=true;
    // Imposta il verso di ordinamento
    dir="asc";
    //Inizia un ciclo che continuerá finché non avrá ordinato tutto
    while(switching)
        {
        switching=false;
        rows=table[classN].rows;
        //Visiona tutte le righe della tabella tranne la prima che contiene le intestazioni
        for (i=1; i<(rows.length-1); i++)
            {
            shouldSwitch=false;
            //Prende i due elementi che deve confrontare, il primo della riga attuale il secondo della successiva
            x=rows[i].getElementsByTagName("TD")[n];
            y=rows[i + 1].getElementsByTagName("TD")[n];
            //Controlla se le due righe dovrebbero cambiare ordine, in base alla direzione dell'ordinamento
            if (dir=="asc")
                {
                if (x.innerHTML.toLowerCase()>y.innerHTML.toLowerCase())
                    {
                    shouldSwitch=true;
                    break;
                    }
                }
               else if (dir=="desc")
                {
                if (x.innerHTML.toLowerCase()<y.innerHTML.toLowerCase())
                    {
                    shouldSwitch=true;
                    break;
                    }
                 }
            }
        if (shouldSwitch)
            {
            //Se é stato segnato un ordinamento da fare, fa l'ordinamento e lo segna come fatto
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching=true;
            //Ogni volta che viene fatto un ordinamento aumenta il count di 1
            switchcount++;
            }
           else
            {
            //Se non é stato fatto nessun ordinamento e la direzione é "asc", mette la direzione "desc e rifá il loop"
            if (switchcount==0 && dir=="asc")
                {
                dir="desc";
                switching=true;
                }
            }
        }
    }



