<!--Work in progress-->
<?php
    session_start();
    if(!isset($_SESSION["credenziali"]))
        header("Location:accesso.php");
    require_once("commonFunctions.php");

    /*Codice che permette di inviare l'email d'invito*/
    if(isset($_POST["inviaEmail"]))
        {
        $email=$_POST["email"];
        $characters= '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $codice=substr(str_shuffle($characters),0, 10);

        $utenti=mysqli_query($db, "SELECT *
                                   FROM utente
                                   WHERE email='$email'");
            
        $utentiR=mysqli_fetch_array($utenti);
            
        if($utentiR==NULL)
            {
            mysqli_query($db, "INSERT INTO Utente (codice)
                               VALUES ('$codice')");

            $subject='Invito a ProjectWork5AI';
            $message="Sei stato invitato a partecipare alla piattaforma di votazioni ProjectWork5AI, inserisci il codice $codice nella pagina di registrazione per poter iniziare a votare!
                        Il link al sito é il seguente:  https://projectwork5ai.altervista.org/votazioni/home.php";
            $headers='From: ProjectWork5AInoreply @ company . com';
            mail($email,$subject,$message,$headers);
            }

        }


    /*codice che permette di fare il logout dalla pagina*/
    if(isset($_POST["logout"]))
        {
        session_destroy();
        header("Location: home.php");
        }



    /*codice che permette di inserire i dati relativi ad una votazione nel db*/        
    if(isset($_POST["votCreation"]) || isset($_POST["votProposal"]))
        {
        $titolo=$_POST["titolo"];
        $testo=$_POST["testo"];
        $percMin=$_POST["percenMin"];
        $nOp=$_POST["nOpzioni"];
        $expDate=$_POST["expireDate"];
        $opzioni=$_POST["opzioni"];
        $credenziali=$_SESSION["credenziali"];
        $CF=$credenziali["CF"];
        $state;
        if(isset($_POST["astensione"]))
            $ast=true;
           else
            $ast=false;

        if(isset($_POST["chiaro"]))
            $votVisible=true;
           else
            $votVisible=false;

        $codiceT=mysqli_query($db, "SELECT codice
                                    FROM utente 
                                    WHERE CF='$CF'");

        $codiceR=mysqli_fetch_array($codiceT);
        $codice=$codiceR[0];


        if(isset($_POST["votCreation"]))
            {
            $state="in_corso";

            mysqli_query($db, "INSERT INTO crea(codice, testoQ)
                               VALUES('$codice', '$testo')");

            $utentiT=mysqli_query($db, "SELECT codice
                                        FROM utente");

            for($utentiR=mysqli_fetch_assoc($utentiT);$utentiR!=NULL;$utentiR=mysqli_fetch_assoc($utentiT))
                {
                $codice=$utentiR['codice'];
                mysqli_query($db, "INSERT INTO partecipa(codice, testoQ)
                                   VALUES('$codice', '$testo')");
                }
            }
           else
            {
            $state="pendente";

            mysqli_query($db, "INSERT INTO propone(codice, testoQ)
                               VALUES('$codice', '$testo')");
            }
        

        mysqli_query($db, "INSERT INTO quesito(testoQ, titolo, scadenza, percMinima, stato, astensione, votoChiaro)
                           VALUES('$testo', '$titolo' ,'$expDate', '$percMin', '$state', '$ast', '$votVisible')");

        for($i=0, $j=0;$i<strlen($opzioni);$i++)
            {
            if($opzioni{$i}==";")
                {
                $opzione=trim(substr($opzioni,$j, $i-$j));

                mysqli_query($db, "INSERT INTO risposta(testoR, testoQ)
                                   VALUES('$opzione', '$testo')");                         
                $j=$i+1;
                }
            } 
               
        }


    /*codice che permette di approvare una votazione proposta*/
    if(isset($_POST["approvePendingVot"]))
        {
        $testoQ=$_POST['pendingVotText'];
        mysqli_query($db, "UPDATE quesito
                           SET stato='in_corso'
                           WHERE testoQ='$testoQ'");

        $utentiT=mysqli_query($db, "SELECT codice
                                    FROM utente");

        for($utentiR=mysqli_fetch_assoc($utentiT);$utentiR!=NULL;$utentiR=mysqli_fetch_assoc($utentiT))
            {
            $codice=$utentiR['codice'];
            mysqli_query($db, "INSERT INTO partecipa(codice, testoQ)
                               VALUES('$codice', '$testoQ')");
            } 
        }

    /*codice che permette di eliminare una votazione proposta*/
    if(isset($_POST["erasePendingVot"]))
        {
        $testoQ=$_POST['pendingVotText'];
        mysqli_query($db, "DELETE FROM quesito
                           WHERE testoQ='$testoQ'"); 

        mysqli_query($db, "DELETE FROM risposta
                           WHERE testoQ='$testoQ'"); 
        }

    /*codice che permette di impostare come cancellati gli account*/    
    if(isset($_POST["eraseAccount"]))
        {
        
        $codice=$_POST["choosenUser"];

        mysqli_query($db, "UPDATE utente
                           SET cancellato=1
                           WHERE codice='$codice'");
   
        
        }
    header("Location: paginaUtente.php");
?>