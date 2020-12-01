<?php
session_start();
include("includes/db.php");
try {
  //Si le boutton ajouter au panier a été cliqué
  if (isset($_POST["addToCart"])) {
    //Envois a la méthode l'ID, la quantité et la connection
    $errorMsg = addToCart($_POST["film_id"], $_POST["quantity"], $conn);
  }
} catch (PDOException $error) {
  $errorMsg = $error->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Nos Films</title>
  <?php include_once("includes/header.php"); ?>
  <style>
  .bg-home {
    background: #a077ff !important;
  }
  </style>
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

  <?php include_once("includes/footer.php"); ?>

  <!--  ====================== BEGIN SCRIPT ====================== -->
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

  // Home Page
  function home() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "home",
      },
      success: function(data) {
        $('#content').html(data);
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#success-alert").slideUp(500);
        });
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

  // Panier
  function panier() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "getPanier",
      },
      success: function(data) {
        $('#content').html(data);
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#success-alert").slideUp(500);
        });
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

  // Supprimer du Panier
  function deleteFromCart(film_id) {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "deleteFromCart",
        film_id: film_id
      },
      success: function(data) {
        $('#content').html(data);
        // cacher l'erreur apres 5 secondes
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#success-alert").slideUp(500);
        });
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


  // Vider Panier
  function viderPanier() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "viderPanier",
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



  // Vider Panier
  function checkout() {
    var checkoutPage = `<section class="jumbotron text-center">
       <div class="container">
         <h1 class="jumbotron-heading">Paiement de Ma Commande</h1>
       </div>
     </section>
     <div class="container">
       <div class="row box">
         <div class="col-md-12">
           <form>
             <div class="row">
               <div class="col-md-6">
                 <label for="firstName">Nom</label>
                 <input type="text" class="form-control" placeholder="Jean Sebastien" value="Jean Sebastien">
               </div>
               <div class="col-md-6">
                 <label for="email">Email</label>
                 <input type="email" class="form-control" placeholder="JeanSebastien@example.com">
               </div>
             </div>
             <div class="mb-3">
               <label for="address">Addresse</label>
               <input type="text" class="form-control" placeholder="1234 Main St">
             </div>
             <div class="row">
               <div class="col-md-6">
                 <label for="country">Pays</label>
                 <select class="custom-select d-block w-100">
                   <option selected>France</option>
                 </select>
               </div>
               <div class="col-md-6">
                 <label for="zip">Zip</label>
                 <input type="text" class="form-control" placeholder="75290">
               </div>
             </div>
             <div class="row mt-3">
               <div class="col-md-6 mb-3">
                 <label for="cc-name">Nom sur la carte</label>
                 <input type="text" class="form-control" placeholder="Jean Sebastien" value="Jean Sebastien">
               </div>
               <div class="col-md-6 mb-3">
                 <label for="cc-number">Numero de Carte</label>
                 <input type="text" class="form-control" placeholder="12345678910">
               </div>
             </div>
             <div class="row">
               <div class="col-md-6">
                 <label for="cc-expiration">Expiration</label>
                 <input type="text" class="form-control" placeholder="03/25">
               </div>
               <div class="col-md-6">
                 <label for="cc-cvv">CVV</label>
                 <input type="text" class="form-control" placeholder="201">
               </div>
             </div>
             <hr class="mb-4">
             <a href="#" onclick="confirmer()" class="btn btn-primary btn-lg btn-block">confirmer</a>
           </form>
         </div>
       </div>
     </div>`;
    $('#content').html(checkoutPage);
  }



  // Confirmer le paiement
  function confirmer() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "confirmer"
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

  // Fetch all categories
  function allcategories() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "categories",
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

  // Add category
  function addCategory() {
    var categoryPage = `<div class="row justify-content-center ">
        <div class="col-12">
          <div class="container login-container">
            <div class="row">
              <div class="col-md-10 login-form-1">
                <h3 class=" d-none d-sm-block text-center">
                  Ajouter une Catégorie
                </h3>
                <div id="message"></div>
                <form>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Titre</label>
                        <input type="text" name="titre" id="catTitle" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <a class="btnSubmit" href="#" onclick="submitCat()">Ajouter</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>`;
    $('#content').html(categoryPage);
  }

  // Submit category
  function submitCat() {
    var catTitle = $("#catTitle").val();
    if (!catTitle) {
      $('#message').html(
        "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur ! </strong> Tous les Champs sont Requis</div>"
      );
      // cacher l'erreur apres 5 secondes
      $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
        $("#danger-alert").slideUp(500);
      });
    } else {
      $.ajax({
        url: 'filmControleur.php',
        type: "post",
        data: {
          action: "addCategory",
          catTitle: catTitle,
        },
        success: function(data) {
          $('#content').html(data);
          $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
          });
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var errorMsg = 'La requête Ajax a échoué: ';
          $('#message').html(
            "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
            data +
            "</div>");
          // cacher l'erreur apres 5 secondes
          $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
          });
        }
      });
    }
  }

  // Edit category
  function editCat(categoryId) {
    $.ajax({
      url: 'filmControleur.php',
      type: "post",
      data: {
        action: "getCategoryById",
        categoryId: categoryId,
      },
      success: function(data) {
        $('#content').html(data);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var errorMsg = 'La requête Ajax a échoué: ';
        $('#message').html(
          "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
          data +
          "</div>");
        // cacher l'erreur apres 5 secondes
        $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#danger-alert").slideUp(500);
        });
      }
    });
  }

  // Save category
  function putCat() {
    var catTitle = $("#catTitle").val();
    var catId = $("#catId").val();
    if (!catTitle) {
      $('#message').html(
        "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur ! </strong> Tous les Champs sont Requis</div>"
      );
      // cacher l'erreur apres 5 secondes
      $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
        $("#danger-alert").slideUp(500);
      });
    } else {
      $.ajax({
        url: 'filmControleur.php',
        type: "post",
        data: {
          action: "updateCategory",
          catTitle: catTitle,
          catId: catId
        },
        success: function(data) {
          $('#content').html(data);
          $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
          });
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var errorMsg = 'La requête Ajax a échoué: ';
          $('#message').html(
            "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
            errorMsg +
            "</div>");
          // cacher l'erreur apres 5 secondes
          $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
          });
        }
      });
    }

  }

  // Delete category
  function deleteCat(categoryId) {
    $.ajax({
      url: 'filmControleur.php',
      type: "post",
      data: {
        id: categoryId,
        action: "deleteCat",
      },
      success: function(data) {
        $('#content').html(data);
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#success-alert").slideUp(500);
        });
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

  // Fetch allFilms
  function allFilms() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "allFilms",
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

  // Add film
  function addFilms() {
    <?php
      $categories = getAllCategories($conn);
      ?>
    var filmPage = `
        <div class="row justify-content-center ">
          <div class="col-12">
            <div class="container login-container">
              <div class="row">
                <div class="col-md-10 login-form-1">
                  <h3 class=" d-none d-sm-block text-center">
                    Ajouter un Film
                  </h3>
                  <div id="message"></div>
                  <form id="addFilm" enctype="multipart/form-data">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label>Titre</label>
                          <input type="text" name="titre" id="titre" class="form-control" required />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Catégorie</label>
                          <select class="form-control" name="category_id" id="category_id">
                            <?php foreach ($categories as $categorie) { ?>
                            <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['titre']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label>Realisateur</label>
                          <input type="text" name="auteur" id="auteur" class="form-control" required />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Prix</label>
                          <input type="number" name="prix" id="prix" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                          <label>Duree</label>
                          <input type="text" name="duree" id="duree" class="form-control" required />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label for="Pochette">Pochette</label>
                          <input type="file" name="image" id="image" class="form-control-file" id="Pochette">
                        </div>
                        <div class="col-md-12">
                          <label>Preview_url</label>
                          <input type="link" name="preview_url" id="preview_url" class="form-control" required />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <a class="btnSubmit" href="#" onclick="submitFilm()">Ajouter</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </div>`;

    $('#content').html(filmPage);
  }

  // Submit film
  function submitFilm() {
    var formData = new FormData();
    var titre = $("#titre").val();
    var category_id = $("#category_id").val();
    var auteur = $("#auteur").val();
    var prix = $("#prix").val();
    var duree = $("#duree").val();
    var image = $('#image')[0].files[0];
    var preview_url = $("#preview_url").val();
    formData.append('titre', titre);
    formData.append('category_id', category_id);
    formData.append('auteur', auteur);
    formData.append('prix', prix);
    formData.append('duree', duree);
    formData.append('image', image);
    formData.append('action', 'newFilm');
    formData.append('preview_url', preview_url);
    if (!titre || !category_id || !auteur || !prix || !duree || !preview_url) {
      $('#message').html(
        "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur ! </strong>  les Champs sont Requis</div>"
      );
      // cacher l'erreur apres 5 secondes
      $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
        $("#danger-alert").slideUp(500);
      });
    } else {
      $.ajax({
        url: 'filmControleur.php',
        type: "post",
        dataType: 'text',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          $('#content').html(data);
          $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
          });
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var errorMsg = 'La requête Ajax a échoué: ';
          $('#message').html(
            "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
            errorMsg +
            "</div>");
          // cacher l'erreur apres 5 secondes
          $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
          });
        }
      });
    }
  }

  // Edit Film
  function editFilm(filmId) {
    $.ajax({
      url: 'filmControleur.php',
      type: "post",
      data: {
        action: "getFilmById",
        filmId: filmId,
      },
      success: function(data) {
        $('#content').html(data);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var errorMsg = 'La requête Ajax a échoué: ';
        $('#message').html(
          "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
          data +
          "</div>");
        // cacher l'erreur apres 5 secondes
        $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#danger-alert").slideUp(500);
        });
      }
    });
  }

  // Save Film
  function putFilm() {
    var formData = new FormData();
    var titre = $("#titre").val();
    var category_id = $("#category_id").val();
    var auteur = $("#auteur").val();
    var prix = $("#prix").val();
    var duree = $("#duree").val();
    var image = $('#image')[0].files[0];
    var preview_url = $("#preview_url").val();
    var filmId = $("#filmId").val();
    formData.append('titre', titre);
    formData.append('category_id', category_id);
    formData.append('auteur', auteur);
    formData.append('prix', prix);
    formData.append('duree', duree);
    formData.append('image', image);
    formData.append('action', 'updateFilm');
    formData.append('preview_url', preview_url);
    formData.append('filmId', filmId);
    if (!titre || !category_id || !auteur || !prix || !duree || !preview_url) {
      $('#message').html(
        "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur ! </strong> Tous les Champs sont Requis</div>"
      );
      // cacher l'erreur apres 5 secondes
      $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
        $("#danger-alert").slideUp(500);
      });
    } else {
      $.ajax({
        url: 'filmControleur.php',
        type: "post",
        dataType: 'text',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          $('#content').html(data);
          $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
          });
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var errorMsg = 'La requête Ajax a échoué: ';
          $('#message').html(
            "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
            errorMsg +
            "</div>");
          // cacher l'erreur apres 5 secondes
          $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
          });
        }
      });
    }

  }

  // Delete Film
  function deleteFilm(filmId) {
    $.ajax({
      url: 'filmControleur.php',
      type: "post",
      data: {
        film_id: filmId,
        action: "deleteFilm",
      },
      success: function(data) {
        $('#content').html(data);
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#success-alert").slideUp(500);
        });
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

  // Fetch membres
  function membres() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "membres",
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

  // Delete Membre
  function deleteMembre(membreId) {
    $.ajax({
      url: 'filmControleur.php',
      type: "post",
      data: {
        id: membreId,
        action: "deleteMembre",
      },
      success: function(data) {
        $('#content').html(data);
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#success-alert").slideUp(500);
        });
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

  // Fetch locations
  function locations() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "locations",
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

  //Page login
  function register(){
    window.location = "login.php";
  }

  // Deconnection
  function logout() {
    $.ajax({
      url: 'filmControleur.php',
      type: "get",
      data: {
        action: "logout",
      },
      success: function(data) {
        if (data == "success") {
          window.location = "login.php";
        }
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