<?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }

  try {
    $films = getAllMovies($conn);
    $errorMsg = "";
    if(isset($_GET['edit'])){
      $id = $_GET['edit'];
    }

    if(isset($_POST["titre"]))  $titre=$_POST["titre"];
    if(
      isset($_POST["addCategory"])){
      $errorMsg = newCategory($titre,$conn);
    }
    if(isset($_POST["updateCategory"])){
      $errorMsg = updateCategory($id,$titre,$conn);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gestion de Catégorie </title>
  <?php include_once("../includes/header.php"); ?>
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
  <main role="main">
    <?php include_once("../includes/adminMenu.php"); ?>
    <div class="col pt-2">
      <?php if (isset($id) && !empty($id) ){
        if(!is_numeric($id)){
          header("location:allFilms.php");
          exit();
		    }
        $category = getCategoryById($id,$conn); ?>
      <div class="row justify-content-center ">
        <div class="col-12">
          <div class="container login-container">
            <div class="row">
              <div class="col-md-10 login-form-1">
                <h3 class=" d-none d-sm-block text-center">
                  Modifier La Catégorie : <?php echo $category["titre"]; ?>
                </h3>
                <form method="post">
                  <?php if(!empty($errorMsg)){ ?>
                  <div class="alert alert-danger" role="alert">
                    <h4 class=" text-center"><?php echo $errorMsg; ?></h4>
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Titre</label>
                        <input type="text" name="titre" class="form-control"
                          value="<?php echo $category["titre"]; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="submit" name="updateCategory" class="btnSubmit" value="Sauvegarder" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php  }else{ ?>

      <div class="row justify-content-center ">
        <div class="col-12">
          <div class="container login-container">
            <div class="row">
              <div class="col-md-10 login-form-1">
                <h3 class=" d-none d-sm-block text-center">
                  Ajouter une Catégorie
                </h3>
                <form method="post">
                  <?php if(!empty($errorMsg)){ ?>
                  <div class="alert alert-danger" role="alert">
                    <h4 class=" text-center"><?php echo $errorMsg; ?></h4>
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Titre</label>
                        <input type="text" name="titre" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="submit" name="addCategory" class="btnSubmit" value="Ajouter" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    </div>
  </main>
  <?php include_once("../includes/footer.php");?>
</body>

</html>