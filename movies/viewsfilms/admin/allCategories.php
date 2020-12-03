<?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  $errorMsg = "";
  try {
    if(isset($_POST["viderPanier"])){
      $errorMsg = viderPanier($conn);
    }
    if(isset($_POST["deleteCategory"])){
      $errorMsg = deleteCategory($_POST["category_id"],$conn);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Liste de Catégories </title>
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
                  Liste de Catégories (<?php  echo count($categories); ?>)
                </h1>
              </div>
            </div>
          </div>
          <div class="container box">
            <div class="row mb-4">
              <div class="col-md-2 ml-auto">
                <a href="newCategory.php" class="btn btn-md btn-block btn-success text-uppercase m-2">
                  <i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter</a>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive table-hover">
                  <table class="table table-striped">
                    <thead class="bg-info text-white">
                      <tr>
                        <th scope="col3">Titre</th>
                        <th colspan="2" scope="col3" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($categories as $category) {?>
                      <tr>
                        <td><?php  echo $category['titre']; ?></td>
                        <td class="text-right">
                          <form method="post">
                            <a href="newCategory.php?edit=<?php echo $category["id"]; ?>" class="btn btn-outline-info">
                              <i class="fa fa-edit" aria-hidden="true"></i>
                              Modifier
                            </a>
                          </form>
                        </td>
                        <td>
                          <form method="post">
                            <input type="hidden" name="category_id" value="<?php echo $category["id"]; ?>">
                            <button type="submit" name="deleteCategory" class="btn btn-outline-danger">
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