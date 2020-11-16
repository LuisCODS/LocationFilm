<?php
session_start();
include("includes/db.php");
//redirectIfLogedIn();

$errorMsg = "";
  try {
    if(isset($_POST["register"])){
      if(empty($_POST["email"]) || empty($_POST["password"])){
          $errorMsg = '<label>Tous les champs sont requis</label>';
      }else{
        $errorMsg = register($_POST["nom"],$_POST["email"],$_POST["password"], $conn);
      }
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Devenir Membre</title>
  <?php include_once("includes/header.php"); ?>
</head>
<style>
</style>

<body>
  <?php include_once("includes/menu.php");?>
  <main role="main">
    <div class="container login-container">
      <div class="row">
        <div class="col-md-10 login-form-1">
          <h3>Devenir Membre</h3>
          <form method="post">
            <?php if(!empty($errorMsg)){ ?>
            <div class="alert alert-danger" role="alert">
              <h4 class=" text-center"><?php if(isset($errorMsg)) echo $errorMsg; ?></h4>
            </div>
            <?php } ?>
            <div class="form-group">
              <label>Votre Nom Complet *</label>
              <input type="text" name="nom" class="form-control" placeholder="Votre Nom Complet *" required />
            </div>
            <div class="form-group">
              <label>Votre Email *</label>
              <input type="email" name="email" class="form-control" placeholder="Votre Email *" required />
            </div>
            <div class="form-group">
              <label>Votre Mot de Passe *</label>
              <input type="password" name="password" class="form-control" placeholder="Votre Mot de Passe *" required />
            </div>
            <div class="row">
              <input type="submit" name="register" class="btnSubmit" value="Creer" />
              <a href="list.php" class="btnCancel"> Annuler </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <?php include_once("includes/footer.php");?>
</body>

</html>