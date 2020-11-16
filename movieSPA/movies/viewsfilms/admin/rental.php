<?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  $rentals = getRentals($conn);
  $errorMsg = "";
  try {
    if(isset($_POST["viderPanier"])){
      $errorMsg = viderPanier($conn);
    }
    if(isset($_POST["deleteMembre"])){
      $errorMsg = deleteMember($_POST["member_id"],$conn);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Liste des Location des Membres </title>
  <?php include_once("../includes/header.php"); ?>
  <link rel="stylesheet" href="../../css/table.css">
</head>

<body>
  <main role="main">
    <?php include_once("../includes/adminMenu.php"); ?>
    <div class="col pt-2">
      <div class="row justify-content-center ">
        <div class="col-12">
          <div class="jumbotron bg-info">
            <div class="row">
              <div class="col main pt-0">
                <h1 class=" d-none d-sm-block text-center text-white">
                  Liste des Location des Membres (<?php  echo count($rentals); ?>)
                </h1>
              </div>
            </div>
          </div>
          <div class="container box">
            <div class="row">
              <div class="col-12">
                <div class="table-responsive table-hover">
                  <table class="table table-striped">
                    <thead class="bg-info text-white">
                      <tr>
                        <th scope="col3">Pochette</th>
                        <th scope="col3">Titre</th>
                        <th scope="col3">Quantite</th>
                        <th scope="col3">Prix</th>
                        <th scope="col3" class="text-center">Total</th>
                        <th scope="col3">Nom du Membre </th>
                        <th scope="col3" width="100">Email du Membre </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($rentals as $rental) {?>
                      <tr>
                        <td><img src="../pochettes/<?php  echo $rental['image']; ?>" height="100" /> </td>
                        <td><?php  echo $rental['titre']; ?></td>
                        <td><?php  echo $rental['quantity']; ?></td>
                        <td><?php  echo $rental['prix']; ?></td>
                        <td class="text-center"><?php  echo ($rental['prix']*$rental['quantity']); ?> $</td>
                        <td><?php  echo $rental['member_name']; ?></td>
                        <td><?php  echo $rental['member_email']; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
  <?php include_once("../includes/footer.php");?>
  <?php
    if(!empty($errorMsg)){
      echo $errorMsg;?>
  <script>
  window.location.reload(false);
  </script>
  <?php }
  ?>
</body>

</html>