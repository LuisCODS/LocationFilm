<?php
  session_start();
  include("includes/db.php");

  $slug = "";

  if (isset($_GET['slug']) && !empty($_GET['slug']) ){
		$slug = $_GET['slug'];
	}else{
    header("location:list.php");
  }
  $cat    = getPageCat($slug,$conn);
  $films  = getMoviesByCategory($slug,$conn);

  $errorMsg = "";
  try {
    if(isset($_POST["addToCart"])){
      $errorMsg = addToCart($_POST["film_id"],$_POST["quantity"], $conn);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Films par Catégorie</title>
  <?php include_once("includes/header.php"); ?>
</head>

<body>
  <main role="main">
    <?php include_once("includes/menu.php"); ?>
    <section class="jumbotron text-center">
      <?php if (!empty($cat)){ ?>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="alert alert-success" role="alert">
            <h1 class="jumbotron-heading"> (<?php echo count($films); ?>) Films dans la catégorie:
              <?php echo $cat["titre"]; ?></h1>
          </div>
          <div class="row">
            <?php foreach($films as $film){ ?>
            <div class="movie-card">
              <div class="movie-header" style="background-image:url(<?php echo 'pochettes/'.$film["image"]; ?>);">
                <div class="header-icon-container">
                  <a href="<?php echo $film["preview_url"]; ?>" data-lity>
                    <i class="header-icon fa fa-play" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
              <div class="movie-content">
                <div class="movie-content-header">
                  <h3 class="movie-title text-center"><?php echo $film["titre"]; ?></h3>
                </div>
                <div class="movie-info">
                  <div class="info-section">
                    <label>Auteur</label>
                    <span><?php echo $film["auteur"]; ?></span>
                  </div>
                  <div class="info-section">
                    <label>Categorie</label>
                    <span><?php echo $film["cat_title"]; ?></span>
                  </div>
                  <div class="info-section">
                    <label>Duree</label>
                    <span><?php echo $film["duree"]; ?></span>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-md-6">
                    <h5>Prix</h5>
                  </div>
                  <div class="col-md-6">
                    <h5><?php echo $film["prix"]; ?> $</h5>
                  </div>
                </div>
                <?php if(checkIfLogedIn()){ ?>
                <form id="myForm" method="post">
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <input type="hidden" name="film_id" value="<?php echo $film["id"]; ?>">
                      <div class="form-group">
                        <select class="form-control" name="quantity">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <button type="submit" name="addToCart" class="btn btn-success btn-sm text-white">
                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        Ajouter</button>
                    </div>
                  </div>
                </form>
                <?php }?>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else{ ?>
      <div class="alert alert-danger" role="alert">
        <h1 class="jumbotron-heading">Catégorie non trouvée !!!</h1>
      </div>
      <?php } ?>

    </section>
  </main>
  <?php include_once("includes/footer.php");?>
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