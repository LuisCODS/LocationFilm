<?php
 session_start();

  include("includes/db.php");
  try {
    //Si le boutton ajouter au panier a été cliqué
    if(isset($_POST["addToCart"]))
    {
      //Envois a la méthode l'ID, la quantité et la connection
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
  <title>Nos Films</title>
  <?php include_once("includes/header.php"); ?>
</head>

<body>
  <main role="main">
    <?php include_once("includes/menu.php"); ?>
    <section class="jumbotron text-center" id="content">
      <div id="customer-data">
        <img src="https://mir-s3-cdn-cf.behance.net/project_modules/disp/35771931234507.564a1d2403b3a.gif">
      </div>
    </section>
  </main>

  <?php include_once("includes/footer.php");?>
     <!--  ====================== SCRIPT ====================== --> 
  <script>
    // AU CHARGEMENT DE LA PAGE
  $(document).ready(function() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "loadfilms"
      },
      success: function(data) {
        $('#content').html(data);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var errorMsg = 'La requête Ajax a échoué: ';
        $('#content').html(
          "<div class='alert alert-danger' id='danger-alert'> <strong> Erreur! </strong>" + errorMsg +
          "</div>");
        // cacher l'erreur apres 5 secondes
        $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#danger-alert").slideUp(500);
        });
      }
    });
  });

  // RECHERCHE PAR CATEGORIES
  function getFilmsByCat(slug, catTitre) {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "getFilmsByCategory",
        slug: slug,
        catTitre: catTitre
      },
      success: function(data) {
        $('#content').html(data);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var errorMsg = 'La requête Ajax a échoué: ';
        $('#content').html(
          "<div class='alert alert-danger' id='danger-alert'> <strong> Erreur! </strong>" + errorMsg +
          "</div>");
        // cacher l'erreur apres 5 secondes
        $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#danger-alert").slideUp(500);
        });
      }
    });
  }
  </script>
       <!--  ====================== FIN SCRIPT ====================== --> 

</body>

</html>