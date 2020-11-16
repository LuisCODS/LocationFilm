<?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  $membres = getAllMembers($conn);
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
  <title>Liste des membres </title>
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
                  Liste des membres (<?php  echo count($membres); ?>)
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
                        <th scope="col3">Nom</th>
                        <th scope="col3" width="100">Email</th>
                        <th colspan="2" scope="col3" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($membres as $membre) {?>
                      <tr>
                        <td><?php  echo $membre['nom']; ?></td>
                        <td class="text-center"><?php  echo $membre['email']; ?></td>
                        <?php if(!$membre["is_admin"]) { ?>
                        <td class="text-right">
                          <form method="post">
                            <input type="hidden" name="member_id" value="<?php echo $membre["id"]; ?>">
                            <button type="submit" name="deleteMembre" class="btn btn-outline-danger">
                              <i class="fa fa-times" aria-hidden="true"></i>
                              Supprimer
                            </button>
                          </form>
                        </td>
                        <?php } else { ?>
                        <td class="text-right">
                          <button type="button" class="btn btn-outline-danger disabled">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Supprimer
                          </button>
                        </td>
                        <?php } ?>

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