<?php
	session_start();
    if(!isset($_SESSION["credenziali"]))
        header("Location:accesso.php");
    if(!isset($_POST["partecipa"]))
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
  	<link rel="stylesheet" type="text/css" href="css/paginaUtente.css"/>
    <link rel="stylesheet" type="text/css" href="css/accesso.css"/>
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
            <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Votazioni
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#" onclick="showLink('links','availableVot')">Votazioni disponibili</a>
              <a class="dropdown-item" href="#" onclick="showLink('links','endedVot')">Votazioni concluse</a>
              <a class="dropdown-item" href="#" onclick="showLink('links','currentVot')">Votazioni in corso</a>
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
      </div>
    </nav>
    <br><br><br>

    <?php
        require_once("commonFunctions.php");
        $credenziali=$_SESSION["credenziali"];
        $CF=$credenziali["CF"];

        /*Codice che controlla le controlla le credenziali inserite, se l'utente é amministratore ecc*/
    	if(isset($_POST["partecipa"]))
        	{
            $actualQ=$_POST["choosenQ"];

            $adminT=mysqli_query($db, "SELECT *
                             		   FROM Utente JOIN Amministratore 
                                       			   ON Utente.codice=Amministratore.codice AND CF='$CF'"); 

            $adminR=mysqli_fetch_array($adminT, MYSQLI_ASSOC);  
            if($adminR!==NULL)
              {
        	  ?><script>hidShow('block', 'none');</script><?php
              }
             else
              {
        	  ?><script>hidShow('none', 'block');</script><?php
              }

            $quesitoT=mysqli_query($db, "SELECT titolo, astensione
                                         FROM quesito
                                         WHERE testoQ='$actualQ'"); 
            
            $risposteT=mysqli_query($db, "SELECT testoR
                                          FROM risposta
                                          WHERE testoQ='$actualQ'"); 

            $quesitoR=mysqli_fetch_array($quesitoT, MYSQLI_ASSOC); 
            ?>
            <div class="text-center">
                <h1 class="col-sm-12"><?php echo $quesitoR['titolo']; ?></h1>
                <p class="col-sm-12"><?php echo $actualQ; ?></p>
                <?php 
                for($risposteR=mysqli_fetch_assoc($risposteT);$risposteR!=NULL;$risposteR=mysqli_fetch_assoc($risposteT))
                    {
                    $optionValue=$risposteR['testoR'];
                    ?>
                    <form method="POST" action="#">
                        <input type="hidden" name="actualQ" value="<?php echo $actualQ; ?>"/>
                        <input class='btn btn-success' type='submit' name='votato' value='<?php echo $optionValue; ?>'/>
                    </form>
                    <?php
                    }
                
                if($quesitoR['astensione'])
                   {
                   ?>
                   <form method="POST" action="#">
                        <input type="hidden" name="actualQ" value="<?php echo $actualQ; ?>"/>
                        <input class='btn btn-success' type='submit' name='astenuto' value='Mi astengo'/>
                   </form>
                   <?php
                   }
                ?>

            </div>
            <?php
            }

        if(isset($_POST["votato"]) || isset($_POST["astenuto"]))
            {
            $actualQ=$_POST["actualQ"];
            $codiceT=mysqli_query($db, "SELECT codice
                                        FROM utente
                                        WHERE CF='$CF'");

            $codiceR=mysqli_fetch_array($codiceT);
            $codice=$codiceR[0];

            $astenuto=0;

            if(isset($_POST["votato"]))
                {
                $testoR=$_POST['votato'];
                mysqli_query($db, "UPDATE risposta
                                   SET votiFavorevoli=votiFavorevoli+1
                                   WHERE testoR='$testoR'");   

                mysqli_query($db, "INSERT INTO vota
                                   VALUES ('$codice', '$testoR', '$actualQ')"); 
                }
               else
                $astenuto=1;

           
            
            mysqli_query($db, "UPDATE partecipa
                               SET presente=true, astenuto='$astenuto'
                               WHERE codice='$codice' AND testoQ='$actualQ'"); 

            header("Location:paginaUtente.php");
            }
    ?> 
  </body>
</html>
