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


    $data['titre'] = '';
    
    if(isset($_POST["titre"]))  $data["titre"] =$_POST["titre"];
    if(isset($_POST["category_id"])) $data["category_id"] = $_POST["category_id"];
    if(isset($_POST["auteur"]))$data["auteur"] = $_POST["auteur"];
    if(isset($_POST["prix"])) $data["prix"] = $_POST["prix"];
    if(isset($_POST["duree"])) $data["duree"] = $_POST["duree"];
    if(isset($_POST["preview_url"])) $data["preview_url"] = $_POST["preview_url"];
    $dossier="../pochettes/";
    
	  $nomPochette=sha1($data["titre"].time());
    $data["image"] ="avatar.jpg";
    $toDelete = 0;
    if(
      isset($_POST["addFilm"])){
        if(!empty($_FILES['image']['tmp_name'])){
          $tmp = $_FILES['image']['tmp_name'];
          $fichier= $_FILES['image']['name'];
          $extension=strrchr($fichier,'.');
          @move_uploaded_file($tmp,$dossier.$nomPochette.$extension);
          // Enlever le fichier temporaire chargé
          @unlink($tmp); //effacer le fichier temporaire
          $pochette=$nomPochette.$extension;
          $data["image"]= $pochette;
        }
      $errorMsg = newFilm($data,$conn);
    }

    if(isset($_POST["updateFilm"])){
        if(!empty($_FILES['image']['tmp_name'])){
          $tmp = $_FILES['image']['tmp_name'];
          $fichier= $_FILES['image']['name'];
          $extension=strrchr($fichier,'.');
          @move_uploaded_file($tmp,$dossier.$nomPochette.$extension);
          // Enlever le fichier temporaire chargé
          @unlink($tmp); //effacer le fichier temporaire
          $pochette=$nomPochette.$extension;
          $data["image"]= $pochette;
          $toDelete = 1;
        }
      $errorMsg = updateFilm($id,$data,$conn,$toDelete);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Ajouter un Film </title>
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
        $film = getFilmById($id,$conn); ?>
      <div class="row justify-content-center ">
        <div class="col-12">
          <div class="container login-container">
            <div class="row">
              <div class="col-md-10 login-form-1">
                <h3 class=" d-none d-sm-block text-center">
                  Modifier Le Film : <?php echo $film["titre"]; ?>
                </h3>
                <form method="post" enctype="multipart/form-data">
                  <?php if(!empty($errorMsg)){ ?>
                  <div class="alert alert-danger" role="alert">
                    <h4 class=" text-center"><?php echo $errorMsg; ?></h4>
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Titre</label>
                        <input type="text" name="titre" class="form-control" value="<?php echo $film["titre"]; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Catégorie</label>
                        <select class="form-control" name="category_id">
                          <?php foreach($categories as $categorie) {?>
                          <option value="<?php echo $categorie['id'];?>"
                            <?php if($categorie["id"]== $film["category_id"]) echo "selected"; ?>>
                            <?php echo $categorie['titre'];?></option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label>Realisateur</label>
                        <input type="text" name="auteur" class="form-control" value="<?php echo $film["auteur"]; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Prix</label>
                        <input type="number" name="prix" class="form-control" value="<?php echo $film["prix"]; ?>" />
                      </div>
                      <div class="col-md-6">
                        <label>Duree</label>
                        <input type="text" name="duree" class="form-control" value="<?php echo $film["duree"]; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="Pochette">Pochette</label>
                        <input type="file" name="image" class="form-control-file" id="Pochette">
                      </div>
                      <div class="col-md-12">
                        <label>Preview_url</label>
                        <input type="link" name="preview_url" class="form-control"
                          value="<?php echo $film["preview_url"]; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="submit" name="updateFilm" class="btnSubmit" value="Sauvegarder" />
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
                  Ajouter un Film
                </h3>
                <form method="post" enctype="multipart/form-data">
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
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Catégorie</label>
                        <select class="form-control" name="category_id">
                          <?php foreach($categories as $categorie) {?>
                          <option value="<?php echo $categorie['id'];?>"><?php echo $categorie['titre'];?></option>
                          <?php }?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label>Realisateur</label>
                        <input type="text" name="auteur" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Prix</label>
                        <input type="number" name="prix" class="form-control" required />
                      </div>
                      <div class="col-md-6">
                        <label>Duree</label>
                        <input type="text" name="duree" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="Pochette">Pochette</label>
                        <input type="file" name="image" class="form-control-file" id="Pochette">
                      </div>
                      <div class="col-md-12">
                        <label>Preview_url</label>
                        <input type="link" name="preview_url" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="submit" name="addFilm" class="btnSubmit" value="Ajouter" />
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