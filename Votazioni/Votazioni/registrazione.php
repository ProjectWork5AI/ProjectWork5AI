<html>
  <head>
  	<meta charset="utf-8">
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/registrazione.css"/>
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
     <div class="text-center exactCenter prova">
        <form method="POST" action="#">
            <div class="form-group">
              <label for="Nome">Nome:</label>
              <input type="text" class="form-control" id="Nome" name="nome" required>
            </div>
            <div class="form-group">
              <label for="Cognome">Cognome:</label>
              <input type="text" class="form-control" id="Cognome" name="cognome" required>
            </div>
            <div class="form-group">
              <label for="C.F.">C.F.:</label>
              <input type="text" class="form-control" id="C.F." name="CF" required>
            </div>
            <div class="form-group">
              <label for="Email">Email:</label>
              <input type="email" class="form-control" id="Email" name="email" placeholder="nome@esempio.com" required>
            </div>
             <div class="form-group">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd" name="password" required>
            </div>
            <div class="form-group">
              <label for="Codice">Codice:</label>
              <input type="text" class="form-control" id="Codice" name="codice" required>
            </div>
            <input class="btn btn-warning" type="submit" name="registrati" value="Registrati">
        </form>
       <p>Ti sei giá registrato? <a href="accesso.php">Clicca qui!</a></p>
    </div>

    <?php
    if(isset($_POST["registrati"]))
      {
      require_once("commonFunctions.php");
      $CF=$_POST['CF'];
      $nome=$_POST['nome'];
      $cognome=$_POST['cognome'];
      $password=hash("sha512", $_POST['password']);
      $email=$_POST['email'];
      $codice=$_POST['codice'];
      $table=mysqli_query($db, "SELECT * 
                                FROM utente WHERE codice='$codice' AND 
                                                  nome IS NULL");
      if($table)
        {
        $row = mysqli_fetch_array($table, MYSQLI_ASSOC);  	
        mysqli_query($db, "UPDATE utente 
                           SET CF='$CF', nome = '$nome', cognome = '$cognome', password = '$password', email = '$email'
                           WHERE codice='$codice' ");
        header("Location:accesso.php");
        echo "<script type='text/javascript'>alert('Registrazione avvenuta con successo');</script>";
        }
       else
        echo "<script type='text/javascript'>alert('Codice errato');</script>";
      }
    ?>
  </body>
</html>