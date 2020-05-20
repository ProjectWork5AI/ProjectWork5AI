<?php
  $db= mysqli_connect("localhost", "root", "", "my_projectwork5ai");
  if(!$db)
  	die("Connection failed: " . mysqli_connect_error());

/**
         *Funzione che esegue la query per ottenere il codice dell'utente.
         *@param db, il database di riferimento.
         *@param CF, il codice fiscale dell'utente di cui cercare il codice
         */
        function user_code($db, $CF)
            {
            $codiceT=mysqli_query($db, "SELECT codice
                                        FROM utente
                                        WHERE CF='$CF'");

            $codiceR=mysqli_fetch_array($codiceT);
            $codice=$codiceR[0];
            return $codice;
            }

        /**
         *Funzione che esegue la query per ottenere la tabella delle votazioni secondo determinati parametri.
         *@param db, il database di riferimento.
         *@param codice, il codice dell'utente.
         *@param state, lo stato della votazione(0, conclusa; 1, in corso).
         *@param present, se si cercano votazioni a cui l'utente era presente o meno(1 se presente, 0 se assente).
         */
        function votQuery($db, $codice, $state, $present)
            {
            $votazioniT=mysqli_query($db, "SELECT *
                            		       FROM quesito JOIN partecipa
                                                        ON partecipa.codice='$codice' AND  
                                                           quesito.testoQ=partecipa.testoQ AND 
                                                           presente='$present' AND
                                                           stato='$state'");
            return $votazioniT;
            }



?>
