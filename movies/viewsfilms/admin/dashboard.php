<?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  $films = getAllMovies($conn);
  $membres = getAllMembers($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tableau de Bord | Films </title>
  <?php include_once("../includes/header.php"); ?>
  <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
  <main role="main">
    <?php include_once("../includes/adminMenu.php"); ?>
    <div class="col main pt-5 mt-3">
      <div class="row justify-content-center ">
        <div class="col-12">
          <?php if(checkIfLogedIn() && is_admin()){ ?>
          <div class="jumbotron bg-info">
            <div class="row m-5">
              <div class="col main pt-5 mt-3">
                <h1 class="display-4 d-none d-sm-block text-center text-white">
                  Bienvenue Admin
                </h1>
                <h4 class="text-center text-white m-5">Vous vous trouvez sur le Tableau de Gestion des Films</h4>
                <div class="row mb-3">
                  <div class="col-xl-4 col-sm-6 py-2">
                    <div class="card bg-success text-white h-100">
                      <div class="card-body bg-success">
                        <div class="rotate">
                          <i class="fa fa-user fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Membres</h6>
                        <h1 class="display-4"><?php echo count($membres); ?></h1>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 py-2">
                    <div class="card text-white bg-danger h-100">
                      <div class="card-body bg-danger">
                        <div class="rotate">
                          <i class="fa fa-film fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Films</h6>
                        <h1 class="display-4"><?php echo count($films); ?></h1>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 py-2">
                    <div class="card text-white bg-warning h-100">
                      <div class="card-body bg-warning">
                        <div class="rotate">
                          <i class="fa fa-list fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Categories</h6>
                        <h1 class="display-4"><?php echo count($categories); ?></h1>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } else{ ?>
          <div class="jumbotron">
            <div class="row m-5">
              <div class="col main">
                <h1 class="display-4 d-none d-sm-block">
                  <div class="row justify-content-center ">
                    <div class="col-12">
                      <div class="jumbotron bg-home">
                        <h1 class="display-4 text-center text-white"> Bienvenue <?php echo $_SESSION["email"]; ?></h1>
                        <hr class="my-4">
                        <h4 class="text-center text-white mb-4">Creez vos locations de films</h4>
                        <p class="lead text-center ">
                          <a class="btn btn-primary btn-lg" href="panier.php" role="button">Mon Panier</a>
                        </p>
                      </div>
                    </div>
                  </div>
                </h1>
              </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include_once("../includes/footer.php");?>
</body>

</html>