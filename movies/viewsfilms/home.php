<?php
 session_start();
  include("includes/db.php");
  $films = getAllMovies($conn);
  if(checkIfLogedIn()){
    header("location:list.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Accueil | Films</title>
  <?php include_once("includes/header.php"); ?>
  <style>
  .bg-home {
    background: #a077ff !important;
  }
  </style>
</head>

<body>
  <main role="main">
    <?php include_once("includes/menu.php"); ?>
    <div class="container">
      <div class="row justify-content-center ">
        <div class="col-12" style="margin-top:10%;">
          <div class="jumbotron bg-home">
            <h1 class="display-4 text-center text-white">Location de Films</h1>
            <hr class="my-4">
            <h4 class="text-center text-white mb-4">Creez Votre Compte ou connectez-vous pour pouvoir gerer vos
              locations de films</h4>
            <p class="lead text-center ">
              <a class="btn btn-primary btn-lg" href="login.php" role="button">Se Connecter</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include_once("includes/footer.php");?>
</body>

</html>