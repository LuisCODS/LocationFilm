<?php
session_start();
include("includes/db.php");
redirectIfLogedIn();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Se Connecter</title>
  <?php include_once("includes/header.php"); ?>

  <script type="text/javascript">
  function validateEmail(email) {
    //Format regex d'un email correct
    var mailformat =
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (email.match(mailformat)) {
      return true;
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $("#login").click(function(e) {
      e.preventDefault();
      //on recupere les valeurs
      var email = $("#email").val();
      var password = $("#password").val();

      // si l'email ou le mot de passe est vide
      if (!email || !password) {
        $('#message').html(
          "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur ! </strong> Tous les Champs sont Requis</div>"
        );
        // cacher l'erreur apres 5 secondes
        $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#danger-alert").slideUp(500);
        });
      } else {

        //on valide l'email
        if (validateEmail(email)) {
          $.ajax({
            url: 'filmControleur.php',
            type: "post",
            data: {
              action: "login",
              email: email,
              password: password
            },
            success: function(data) {
              if (data == "Success") {
                window.location = "index.php";
              } else {
                $('#message').html(
                  "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
                  data +
                  "</div>");
                // cacher l'erreur apres 5 secondes
                $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
                  $("#danger-alert").slideUp(500);
                });
              }
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
        } else {
          $('#message').html(
            "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Email Invalide ! </strong> Veuillez Ressayer</div>"
          );
          // cacher l'erreur apres 5 secondes
          $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
          });
        }
      }

    });
  });

  function register() {
    
    var registerPage = `<div class="container login-container">
      <div class="row">
        <div class="col-md-10 login-form-1">
          <h3>Devenir Membre</h3>
          <form>
           <div id="message"></div>
            <div class="form-group">
              <label>Votre Nom Complet *</label>
              <input type="text" name="nom" id="nom" class="form-control" placeholder="Votre Nom Complet *" required />
            </div>
            <div class="form-group">
              <label>Votre Email *</label>
              <input type="email" name="email" id="emailregister" class="form-control" placeholder="Votre Email *" required />
            </div>
            <div class="form-group">
              <label>Votre Mot de Passe *</label>
              <input type="password" name="password" id="passwordregister" class="form-control" placeholder="Votre Mot de Passe *" required />
            </div>
            <div class="row">
              <a href="#" id="registerBtn" onclick="createAccount()" class="btnSubmit"> Creer</a>
              <a href="index.php" class="btnCancel"> Annuler </a>
            </div>
          </form>
        </div>
      </div>
    </div>`;
    $('#content').html(registerPage);
  }

  function createAccount() {
    var name = $("#nom").val();
    var email = $("#emailregister").val();
    var password = $("#passwordregister").val();
    // si l'email ou le mot de passe est vide
    if (!email || !password || !name) {
      $('#message').html(
        "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur ! </strong> Tous les Champs sont Requis</div>"
      );
      // cacher l'erreur apres 5 secondes
      $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
        $("#danger-alert").slideUp(500);
      });
    } else {

      //on valide l'email
      if (validateEmail(email)) {
        $.ajax({
          url: 'filmControleur.php',
          type: "post",
          data: {
            action: "register",
            name: name,
            email: email,
            password: password
          },
          success: function(data) {
            if (data == "Success") {
              window.location = "index.php";
            } else {
              $('#message').html(
                "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Erreur! </strong>" +
                data +
                "</div>");
              // cacher l'erreur apres 5 secondes
              $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
                $("#danger-alert").slideUp(500);
              });
            }
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
      } else {
        $('#message').html(
          "<div class='alert alert-danger text-center' id='danger-alert'> <strong> Email Invalide ! </strong> Veuillez Ressayer</div>"
        );
        // cacher l'erreur apres 5 secondes
        $("#danger-alert").fadeTo(5000, 500).slideUp(500, function() {
          $("#danger-alert").slideUp(500);
        });
      }
    }
  }
  </script>
</head>

<body>
  <main role="main">
    <?php include_once("includes/menu.php"); ?>
    <div id="content">
      <div class="container login-container">
        <div class="row">
          <div class="col-md-10 login-form-1">
            <h3>Connexion</h3>
            <form>
              <div id="message"></div>
              <?php if (!empty($errorMsg)) { ?>
              <div class="alert alert-danger" role="alert">
                <h4 class=" text-center"><?php if (isset($errorMsg)) echo $errorMsg; ?></h4>
              </div>
              <?php } ?>

              <div class="form-group">
                <label>email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Votre Email *" />
              </div>

              <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control"
                  placeholder="Votre Mot de Passe *" />
              </div>

              <div class="row">
                <input type="submit" name="login" id="login" class="btnSubmit" value="Se connecter" />
                <a href="index.php" class="btnCancel"> Annuler </a>
              </div>
            </form>
          </div>
        </div>
      </div>
  </main>
  <?php include_once("includes/footer.php"); ?>
</body>

</html>