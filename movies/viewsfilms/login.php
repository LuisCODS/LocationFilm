<?php
session_start();
  include("includes/db.php");
  redirectIfLogedIn();
 $errorMsg = "";
  try {
    if(isset($_POST["login"])){
      if(empty($_POST["email"]) || empty($_POST["password"])){
          $errorMsg = '<label>Tous les champs sont requis</label>';
      }else{
        $errorMsg = login($_POST["email"],$_POST["password"], $conn);
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
  <title>Se Connecter</title>
  <?php include_once("includes/header.php"); ?>
</head>

<body>
  <main role="main">
    <?php include_once("includes/menu.php");?>
    <div class="container login-container">
      <div class="row">
        <div class="col-md-10 login-form-1">
          <h3>Connexion</h3>
          <form method="post">
            <?php if(!empty($errorMsg)){ ?>
            <div class="alert alert-danger" role="alert">
              <h4 class=" text-center"><?php if(isset($errorMsg)) echo $errorMsg; ?></h4>
            </div>
            <?php } ?>
            <div class="form-group">
              <label>email</label>
              <input type="email" name="email" class="form-control" placeholder="Votre Email *" required />
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="Votre Mot de Passe *" required />
            </div>

            <div class="row">
              <input type="submit" name="login" class="btnSubmit" value="Se connecter" />
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