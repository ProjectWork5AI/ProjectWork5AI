<?php
	session_start();
?>
<html>
  <head>
  	<meta charset="utf-8">
    <title>Accesso</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/accesso.css"/>
  </head>

  <body class="container-fluid back">
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
        </ul>
      </div>
    </nav>

    <div class="text-center exactCenter">
      <h1 class="col-sm">Modifica la tua password:</h1> 	
      <form method="POST" action="#">
          <span class="row"><label class="col-xl-4">Nuova password:</label><input class="col-xl" type="password" name="password" required></span><br>
          <span class="row"><label class="col-xl-4">Conferma password:</label><input class="col-xl" type="password" required></span><br>
          <input class="btn btn-info" type="submit" name="cambiaPassword" value="Cambia Password">
      </form>
     </div> 

    <?php
    if(isset($_POST["cambiaPassword"]))
    	{
        require_once("commonFunctions.php");
      	$CF=$_SESSION['CF'];
      	$password=hash("sha512", $_POST['password']);
      	mysqli_query($db, "UPDATE utente
          		 		   SET password='$password'
                           WHERE CF='$CF'"); 
     	header("Location:accesso.php");
       }
    ?>
  </body>
</html>
