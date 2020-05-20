<?php
	session_start();
    if(!isset($_SESSION["credenziali"]))
        header("Location:accesso.php");
?>
<html>
  <head>
  	<meta charset="utf-8">
    <title>Sito votazioni</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/jqueries.js"></script>   
  	<link rel="stylesheet" type="text/css" href="css/paginaUtente.css">
    <link rel="stylesheet" type="text/css" href="css/accesso.css">
  </head>

  <body class="container-fluid back text-center">
  	 <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <a class="navbar-brand" href="#">Sito votazioni</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="paginaUtente.php">Home </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="bacheca.php">Bacheca</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Votazioni
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#" onclick="showLink('links','availableVot')">Votazioni disponibili</a>
              <a class="dropdown-item" href="#" onclick="showLink('links','endedVot')">Votazioni concluse</a>
              <a class="dropdown-item" href="#" onclick="showLink('links','currentVot')">Votazioni in corso</a>
              <a class="dropdown-item amministratore" href="#" onclick="showLink('links','pendingVot')">Votazioni pendenti</a>
              <div class="utente">
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" onclick="showLink('links','proposeVot')">Proponi votazione</a>
              </div>
              <div class="amministratore">
              	<div class="dropdown-divider"></div>
              	<a class="dropdown-item" href="#" onclick="showLink('links','createVot')">Crea votazione</a>
                <a id="openInvite" class="dropdown-item"  href="#">Invita nuovo utente</a>   
              </div>
            </div>
          </li>
          <li class="nav-item active amministratore">
            <a class="nav-link" href="#" onclick="showLink('links','showUser')">Utenti</a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
              <form class="my-lg-0" method="POST" action="paginaUtentePHP.php">
                  <input class="btn btn-danger" type="submit" name="logout" value="Logout">
              </form>
          </li>
        </ul>
      </div>
    </nav>
    <br><br><br>

    <!--Form che permette di inserire i dati relativi alla creazione di una votazione-->
    <div class="createVot proposeVot links text-center prova">
        <form method="POST" action="paginaUtentePHP.php">
            <div class="form-group">
              <label for="Titolo">Titolo:</label>
              <input type="text" class="form-control" id="Titolo" name="titolo" required>
              <p id="provacontrollo" style="display:none">proveremo</p>
            </div>
            <div class="form-group">
              <label for="Testo">Testo:</label>
              <textarea class="form-control" id="Testo" name="testo" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="percMin">Percentuale minima:</label>
              <input type="number" class="form-control" id="percMin" name="percenMin" min="0" max="100" step="5" onKeyDown="return false" required>
            </div>
            <div class="form-group">
                <label for="n_Opzioni">Numero opzioni:</label>
                <select class="custom-select custom-select-lg mb-3" id="n_Opzioni" name="nOpzioni">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expire_Date">Data di scadenza:</label>
                <input class="form-control" type="datetime-local" id="expire_Date" name="expireDate" required>
            </div>
            <div class="form-group">
              <label for="Opzioni">Opzioni:</label>
              <textarea class="form-control" id="Opzioni" name="opzioni" rows="3" placeholder="opzione1;&#x0a;opzione2;&#x0a;...;" required></textarea>  
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="astensione_" name="astensione" value="true">
              <label class="custom-control-label" for="astensione_">Possibilitá di astensione</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="chiaro_" name="chiaro" value="true">
              <label class="custom-control-label" for="chiaro_">Voto in chiaro</label>
            </div>
            <br>
            <div class="createVot links text-center">
                <input class="btn btn-warning" type="submit" name="votCreation" value="Crea votazione">
            </div>
            <div class="proposeVot links text-center">
                <input class="btn btn-warning" type="submit" name="votProposal" value="Proponi votazione">
            </div>
        </form>  
    </div>
    
    <!--Parte in cui viene creata la tabella con le votazioni disponibili a cui si puó partecipare-->
    <!--WORK IN PROGRESS-->
    <div class="availableVot links">
        <input type="text" class="form-control searchInput" placeholder="Search for names..">
        <?php
          require_once("commonFunctions.php");
          $credenziali=$_SESSION["credenziali"];
          $CF=$credenziali["CF"];
          $codice=user_code($db, $CF);
          $votazioniT=votQuery($db, $codice, "in_corso' OR 'in_scadenza", 0);
          if($votazioniT!==NULL)
            {?>
            <div style="overflow-x:auto;">
                <table class="table-info tableBack votTable">
                    <thead>
                      <tr class="header">
                            <th onclick="sortTable(0,0)">Titolo <img src="css/arrows.png"></th>
                            <th onclick="sortTable(1,0)">Scadenza <img src="css/arrows.png"></th>
                            <th onclick="sortTable(2,0)">Percentuale minima <img src="css/arrows.png"></th>
                            <th>Partecipa</th>
                      </tr>
                    </thead>
                    <tbody class="searchTable">
                      <?php
                      for($votazioniR=mysqli_fetch_assoc($votazioniT);$votazioniR!=null;$votazioniR=mysqli_fetch_assoc($votazioniT))
                            {
                            ?>
                            
                            <tr>
                                <td>
                                    <?php echo $votazioniR["titolo"];?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["scadenza"];?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["percMinima"];?>
                                </td>
                                <td>
                                    <form method="POST" action="votazione.php">
                                        <input type="hidden" name="choosenQ" value="<?php echo $votazioniR['testoQ']; ?>"/>
                                        <input class="btn btn-success" type="submit" name="partecipa" value="Partecipa"/>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            }
                      ?>
                    </tbody>
                </table>
            </div>
            <?php
            }
           else
            echo "Non sono disponibili nuove votazioni";
            ?>
         
    </div>

    <!--Parte in cui viene creata la tabella con le votazioni concluse-->
    <!--WORK IN PROGRESS-->
    <div class="endedVot links">
        <input type="text" class="form-control searchInput" placeholder="Cerca la votazione che ti interessa">
        <div style="overflow-x:auto;">
            <table class="table-info tableBack votTable">
                <thead>
                  <tr class="header">
                        <th onclick="sortTable(0,1)">Titolo <img src="css/arrows.png"></th>
                        <th onclick="sortTable(1,1)">Scadenza <img src="css/arrows.png"></th>
                        <th onclick="sortTable(2,1)">Opzione vincente <img src="css/arrows.png"></th>
                  </tr>
                </thead>
                <tbody class="searchTable">
                  <tr>

                  <?php
                      require_once("commonFunctions.php");
                      ended_current_vot($db, "scaduta");
                  ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="currentVot links">
        <input type="text" class="form-control searchInput" placeholder="Cerca la votazione che ti interessa">
        <div style="overflow-x:auto;">
            <table class="table-info tableBack votTable">
                <thead>
                  <tr class="header">
                        <th onclick="sortTable(0,2)">Titolo <img src="css/arrows.png"></th>
                        <th onclick="sortTable(1,2)">Scadenza <img src="css/arrows.png"></th>
                        <th onclick="sortTable(2,2)">Opzione che sta vincendo <img src="css/arrows.png"></th>
                  </tr>
                </thead>
                <tbody class="searchTable">
                     <tr>

                     <?php
                         require_once("commonFunctions.php");
                         ended_current_vot($db, "in_corso' OR stato='in_scadenza");
                     ?>

                </tbody>
            </table>
        </div>
    </div>


      <div class="pendingVot links">
        <input type="text" class="form-control searchInput" placeholder="Search for names..">
        <?php
          require_once("commonFunctions.php");
          $credenziali=$_SESSION["credenziali"];
          $CF=$credenziali["CF"];

          $votazioniT=mysqli_query($db, "SELECT nome, cognome, titolo, quesito.testoQ, scadenza, percMinima, astensione, votoChiaro
                                         FROM quesito JOIN (utente JOIN propone ON utente.codice=propone.codice) 
                                         ON stato='pendente' AND quesito.testoQ=propone.testoQ");
          
          if($votazioniT!==NULL)
            {?>
            <div style="overflow-x:auto;">
                <table class="table-info tableBack votTable">
                    <thead>
                      <tr class="header">
                            <th onclick="sortTable(0,3)">Utente <img src="css/arrows.png"></th>
                            <th onclick="sortTable(1,3)">Titolo <img src="css/arrows.png"></th>
                            <th onclick="sortTable(2,3)">Testo <img src="css/arrows.png"></th>
                            <th onclick="sortTable(3,3)">Scadenza <img src="css/arrows.png"></th>
                            <th onclick="sortTable(4,3)">Percentuale minima <img src="css/arrows.png"></th>
                            <th onclick="sortTable(5,3)">Astensione<img src="css/arrows.png"></th>
                            <th onclick="sortTable(6,3)">Voto in chiaro<img src="css/arrows.png"></th>
                            <th onclick="sortTable(7,3)">Risposte<img src="css/arrows.png"></th>
                            <th>Approva</th>
                            <th>Elimina</th>
                      </tr>
                    </thead>
                    <tbody class="searchTable">
                      <?php
                      for($votazioniR=mysqli_fetch_assoc($votazioniT);$votazioniR!=null;$votazioniR=mysqli_fetch_assoc($votazioniT))
                            {                          
                            $testoQ=$votazioniR["testoQ"];

                            $risposteT=mysqli_query($db, "SELECT testoR
                                                          FROM risposta
                                                          WHERE testoQ='$testoQ'");
                            ?>
                            <tr>
                                <td>
                                    <?php echo $votazioniR["nome"]."<br>".$votazioniR["cognome"];?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["titolo"];?>
                                </td>
                                <td>
                                    <?php echo $testoQ;?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["scadenza"];?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["percMinima"];?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["astensione"];?>
                                </td>
                                <td>
                                    <?php echo $votazioniR["votoChiaro"];?>
                                </td>
                                <td>
                                    <?php 
                                    
                                    for($risposteR=mysqli_fetch_assoc($risposteT);$risposteR!=null;$risposteR=mysqli_fetch_assoc($risposteT)) 
                                        {
                                        echo $risposteR["testoR"].";<br>";
                                        }
                                        ?>
                                </td>
                                <td>
                                    <form method="POST" action="paginaUtentePHP.php">
                                        <input type="hidden" name="pendingVotText" value="<?php echo $testoQ; ?>"/>
                                        <input class="btn btn-success" type="submit" name="approvePendingVot" value="Approva"/>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="paginaUtentePHP.php">
                                        <input type="hidden" name="pendingVotText" value="<?php echo $testoQ; ?>"/>
                                        <input class="btn btn-danger" type="submit" name="erasePendingVot" value="Elimina"/>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            }
                      ?>
                    </tbody>
                </table>
            </div>
            <?php
            }
           else
            echo "Non sono disponibili nuove votazioni";
            ?>
    </div>





    <!--Form che permette di invitare nuovi utenti tramite l'inserimento del loro indirizzo email-->
    <div class="form-popup" id="myForm">
        <form action="paginaUtentePHP.php" method="POST" class="form-container">
            <p>Inserisci l'email dell'utente che vuoi invitare e gli verrá inviata un'email con tutte le istruzioni per poter partecipare</p>
            <div class="form-group">
              <label for="Email">Email:</label>
              <input type="email" class="form-control" id="Email" name="email" placeholder="Inserisci email" required>
            </div>
            <button type="submit" name="inviaEmail" class="btn">Invia</button>
            <button type="submit" id="closeInvite" class="btn cancel">Chiudi</button>
        </form>
    </div>    
    
    <!--Parte in cui viene creata la tabella con gli utenti-->
    <div class="showUser links">
      <input type="text" class="form-control searchInput" placeholder="Cerca l'utente che ti interessa">
      <?php 
        require_once("commonFunctions.php");

        $utenteT=mysqli_query($db, "SELECT nome, cognome, email, codice
                                    FROM utente
                                    WHERE cancellato=0 && CF!='$CF'");
        
        if($utenteT)
            {?>
            <div style="overflow-x:auto;">
                <table class="table-info tableBack votTable">
                    <thead>
                        <tr class="header">
                            <th onclick="sortTable(0,4)">Nome<img src="css/arrows.png"></th>
                            <th onclick="sortTable(1,4)">Cognome<img src="css/arrows.png"></th>
                            <th onclick="sortTable(2,4)">Email<img src="css/arrows.png"></th>
                            <th>Elimina</th>
                        </tr>
                    </thead>
                    <tbody class="searchTable">
                        <?php
                        for($utenteR=mysqli_fetch_array(($utenteT), MYSQLI_ASSOC);$utenteR!=null;$utenteR=mysqli_fetch_assoc($utenteT))
                            {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $utenteR["nome"];?>
                                </td>
                                <td>
                                    <?php echo $utenteR["cognome"];?>
                                </td>
                                <td>
                                    <?php echo $utenteR["email"];?>
                                </td>
                                <td>
                                    <form method="POST" action="paginaUtentePHP.php">
                                        <input type="hidden" name="choosenUser" value="<?php echo $utenteR['codice']; ?>"/>
                                        <input class="btn btn-danger" type="submit" name="eraseAccount" value="Elimina"/>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                    </tbody>
                </table>
            </div>
            <?php
            }
           else
            echo "no";
        ?>
    </div>   

    <?php
        require_once("commonFunctions.php");

        /*Codice che controlla le controlla le credenziali inserite, se l'utente é amministratore ecc*/
    	if(isset($_SESSION["credenziali"]))
            {
            $credenziali=$_SESSION["credenziali"];
            $CF=$credenziali["CF"];
            $password=$credenziali["password"];

            $utenteT=mysqli_query($db, "SELECT nome, cognome
                            		    FROM utente
                           		        WHERE CF='$CF' AND password='$password'"); 

            $utenteR=mysqli_fetch_array($utenteT, MYSQLI_ASSOC);  
            $nome=$utenteR['nome'];
            $cognome=$utenteR['cognome'];
            echo "<h1 class='col-sm links' style='display:block;'>Benvenuto/a $nome $cognome!</h1>";
            $adminR=adminQuery($db, $CF); 
      
            if($adminR!==NULL)
                {
        	    ?><script>hidShow('block', 'none');</script><?php
                }
                else
                {
        	    ?><script>hidShow('none', 'block');</script><?php
                }
              }
            

        
         /**
         *Funzione che esegue la query per sapere se l'utente é amministratore o meno.
         *@param db, il database di riferimento.
         *@param CF, il codice fiscale dell'utente.
         */
        function adminQuery($db, $CF)
            {
            $adminT=mysqli_query($db, "SELECT *
                             		   FROM utente JOIN amministratore 
                                       			   ON utente.codice=amministratore.codice AND CF='$CF'"); 

            $adminR=mysqli_fetch_array($adminT, MYSQLI_ASSOC); 
            return $adminR;
            }

        /**
         *Funzione che crea le tabelle delle votazioni concluse e in corso.
         *@param db, il database di riferimento.
         *@param state, scaduta se deve fare le votazioni concluse, in_corso se deve fare quelle in corso in_scadenza.
         */
        function ended_current_vot($db, $state)
            {
            $credenziali=$_SESSION["credenziali"];
            $CF=$credenziali["CF"];
            $adminR=adminQuery($db, $CF); 

            if($adminR!==NULL)
                $votazioniT=mysqli_query($db, "SELECT *
                            		            FROM quesito
                                                WHERE stato='$state'");
               else
                {
                $codice=user_code($db, $CF);
                $votazioniT=votQuery($db, $codice, $state, 1);
                }      
            if($votazioniT)
                {
                for($votazioniR=mysqli_fetch_assoc($votazioniT);$votazioniR!=null;$votazioniR=mysqli_fetch_assoc($votazioniT))
                    {
                    $key=$votazioniR['testoQ'];

                    $winningOpT=mysqli_query($db, "SELECT testoR
                                                   FROM risposta
                                                   WHERE testoQ='$key' AND votiFavorevoli=(SELECT MAX(votiFavorevoli) AS winningOp
                                                                                           FROM risposta
                                                                                           WHERE testoQ='$key')");

                    $winningOpR=mysqli_fetch_array($winningOpT);
                    $numR=mysqli_num_rows($winningOpT);
                    echo "<td>".$votazioniR["titolo"]."</td>";
                    echo "<td>".$votazioniR["scadenza"]."</td>";
                    if($state==1)
                        {
                        if($numR==1)
                            echo "<td>".$winningOpR[0]."</td>";
                           else
                            {
                            echo"<td><b>Pareggio tra:</b>";
                            for(;$winningOpR!=NULL;$winningOpR=mysqli_fetch_array($winningOpT))
                                echo "<br>".$winningOpR[0].";";
                            echo"</td>";
                            }
                        }
                       else
                        echo "<td>".$winningOpR["testoR"]."</td>";
                    echo"</tr>";
                    }
                }
               else
                echo "Niente di nuovo";
            }
    ?> 
  </body>
</html>
