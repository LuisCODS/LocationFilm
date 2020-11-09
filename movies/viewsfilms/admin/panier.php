<?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  $locations = getPanier($conn);
  $errorMsg = "";
  try {
    if(isset($_POST["viderPanier"])){
      $errorMsg = viderPanier($conn);
    }
    if(isset($_POST["deleteFromCart"])){
      $errorMsg = supprimerDuPanier($_POST["film_id"],$conn);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Mon Panier </title>
  <?php include_once("../includes/header.php"); ?>
  <link rel="stylesheet" href="../../css/table.css">
</head>

<body>
  <main role="main">
    <?php include_once("../includes/adminMenu.php"); ?>
    <?php if(count($locations)){ ?>
    <section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Mon Panier de Locations</h1>
      </div>
    </section>
    <div class="container">
      <div class="row mb-4">
        <div class="col-md-4 text-left">
          <h4>(<?php echo count($locations); ?>) Films</h4>
        </div>
        <div class="col-md-5 text-right ">
          <div class="btn-group">
            <a href="../list.php" class="btn btn-md btn-block btn-info text-uppercase m-2">
              <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Continuer de Louer</a>
            <a href="checkout.php" class="btn btn-md btn-block btn-success text-uppercase m-2">
              Passer Votre commande <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            <form method="post">
              <button type="submit" name="viderPanier" class="btn btn-md btn-block btn-danger text-uppercase m-2">
                <i class="fa fa-trash" aria-hidden="true"></i>
                Vider Panier
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="row ">
        <div class="col-12">
          <div class="table-responsive table-hover  box">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Pochette</th>
                  <th scope="col">Titre</th>
                  <th scope="col" width="100">Quantite</th>
                  <th scope="col" width="100">Prix</th>
                  <th scope="col" width="200" class="text-right">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($locations as $location) {
                  $final_price = $location['quantity'] * $location['prix'];
                  $total = 0;
                  $total += $final_price;
                  ?>
                <tr>
                  <td><img src="../pochettes/<?php  echo $location['image']; ?>" height="100" /> </td>
                  <td><?php  echo $location['titre']; ?></td>
                  <td class="text-center"><?php  echo $location['quantity']; ?></td>
                  <td class="text-center"><?php  echo $final_price; ?> $</td>
                  <td class="text-right">
                    <form method="post">
                      <input type="hidden" name="film_id" value="<?php echo $location["id"]; ?>">
                      <button type="submit" name="deleteFromCart" class="btn btn-outline-danger">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Supprimer
                      </button>
                    </form>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="row mb-4">
            <div class="col-md-2 ml-auto">
              <h4>Récapitulatif</h4>
              <?php

                $tvq = ($total * 9.975) / 100;
                $tps = ($total * 5) / 100;
                $grandTotal = $total + $tvq + $tps;
              ?>
              <p>
                Sous-Total:$ <?php echo $total; ?> $ <br />
                TVQ: $<?php echo $tvq; ?><br />
                TPS: $<?php echo $tps; ?>$<br />
                Total: $<?php echo $grandTotal; ?>$<br />
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php }else { ?>
    <section class="text-center">
      <div class="container text-center">
        <div class="row justify-content-center ">
          <div class="col-12" style="margin-top:10%;">
            <div class="jumbotron bg-panier">
              <h1 class="jumbotron-heading">Votre Panier de Locations est Vide</h1>
              <hr class="my-4">
              <p class="lead text-center ">
                <a class="btn btn-success btn-lg" href="../list.php"> <i class="fa fa-arrow-circle-left"
                    aria-hidden="true"></i> Continuer de Louer</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
  </main>
  <?php include_once("../includes/footer.php");?>
  <?php
    if(!empty($errorMsg)){
      echo $errorMsg;?>
  <script>
  setTimeout(function() {
    window.location.reload(false);
  }, 2000);
  </script>
  <?php }
  ?>
</body>

</html>