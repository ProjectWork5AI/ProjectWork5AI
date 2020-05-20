<?php 
  session_start();
  if(!isset($_SESSION["credenziali"]))
    header("Location:accesso.php");
?>
<html>
  <head>
  	<meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  	<link rel="stylesheet" type="text/css" href="css/home.css"/>   
  	<link rel="stylesheet" type="text/css" href="css/paginaUtente.css">
  </head>
  <body class="container-fluid back text-center" >
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
      <div class="align-self-center exactCenter">
        <?php
        require_once("commonFunctions.php");
        $credenziali=$_SESSION["credenziali"];
        $CF=$credenziali["CF"];
        $codice=user_code($db, $CF);
        $votazioniT=votQuery($db, $codice, "in_scadenza", 0);
        if($votazioniT!==NULL)
            {?>
            <table class="table-info tableBack votTable">
                <thead>
                  <tr>
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
            <?php
            }
           else
            echo "Non sono disponibili nuove votazioni";
            ?>
      </div>  
    
  </body>
</html>
