<?php
session_start();
include("includes/db.php");
$stmt = $conn->prepare('SELECT * FROM categories');
$stmt->execute();
$categories = $stmt->fetchAll();
$rentals = getRentals($conn);
$membres = json_decode(getAllMembers($conn),true);
$films = json_decode(getAllMovies($conn),true);

$getAction = "";
$postAction = "";

if(isset($_GET['action'])){
  $getAction = $_GET['action'];
}

if(isset($_POST['action'])){
  $postAction = $_POST['action'];
}

if ($getAction || $postAction) {

  //Load Films and Get films By Category
  if (($getAction == 'loadfilms' || $getAction == 'getFilmsByCategory' || $getAction == 'allFilms' || $postAction == "newFilm" || $postAction == "updateFilm" || $postAction == "deleteFilm")) {
    $msg = "";
    $header = "";
    if ($getAction == 'loadfilms' && ! is_admin()) {
      $films = getAllMovies($conn);
      $films = json_decode($films, true);
    } else if ($getAction == 'getFilmsByCategory') {
      $slug = $_GET['slug'];
      $catTitre = $_GET['catTitre'];
      $films = getMoviesByCategory($slug, $conn);
      $films = json_decode($films, true);
      $header = '<div class="alert alert-success" role="alert"><h1 class="jumbotron-heading"> (' . count($films) . ') Films dans la catégorie: ' . $catTitre . '</h1></div>';
    }
    $filmListing = '<div class="album py-5 bg-light">
  <div class="container">
  ' . $header . '
    <div class="row">';
    if (!empty($films)) {
      foreach ($films as $film) {
        $filmListing .= '<div class="movie-card">
          <div class="movie-header" style="background-image:url(pochettes/' . $film["image"] . ');">
            <div class="header-icon-container">
              <a href="' . $film["preview_url"] . '" data-lity>
                <i class="header-icon fa fa-play" aria-hidden="true"></i>
              </a>
            </div>
          </div>
          <div class="movie-content">
            <div class="movie-content-header">
              <h3 class="movie-title text-center">' . $film["titre"] . '</h3>
              <div class="imax-logo"></div>
            </div>
            <div class="movie-info">
              <div class="info-section">
                <label>Auteur</label>
                <span>' . $film["auteur"] . '</span>
              </div>
              <div class="info-section">
                <label>Categorie</label>
                <span>' . $film["cat_title"] . '</span>
              </div>
              <div class="info-section">
                <label>Duree</label>
                <span>' . $film["duree"] . '</span>
              </div>
              <div class="info-section">
                <label>Prix</label>
                <span>' . $film["prix"] . ' $</span>
              </div>
            </div>';

        if (checkIfLogedIn()) {
          $filmListing .= '<form id="myForm" method="post">
            <div class="row mt-3">
              <div class="col-md-6">
                <input type="hidden" name="film_id" value="' . $film["id"] . '">
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
          </form>';
        }
        $filmListing .= '
        </div>
      </div>';
      }
      $filmListing .= '</div>
    </div>
    </div>';
    } else {
      $filmListing = '<div class="alert alert-danger" role="alert">
    <h1 class="jumbotron-heading">Aucun Film.</h1>
    </div>';
    }
    if ($getAction == 'loadfilms' && is_admin()) {
      $filmListing = '<div class="jumbotron bg-info">
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
                        <h1 class="display-4">' . count($membres) . '</h1>
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
                        <h1 class="display-4">' . count($films) . '</h1>
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
                        <h1 class="display-4">' . count($categories) . '</h1>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>';
    }
    if ($getAction == 'allFilms' || $postAction == "newFilm" || $postAction == "updateFilm" || $postAction == "deleteFilm") {
      if ($postAction == "newFilm") {
        $data['titre'] = '';
        if (isset($_POST["titre"]))  $data["titre"] = $_POST["titre"];
        if (isset($_POST["category_id"])) $data["category_id"] = $_POST["category_id"];
        if (isset($_POST["auteur"])) $data["auteur"] = $_POST["auteur"];
        if (isset($_POST["prix"])) $data["prix"] = $_POST["prix"];
        if (isset($_POST["duree"])) $data["duree"] = $_POST["duree"];
        if (isset($_POST["preview_url"])) $data["preview_url"] = $_POST["preview_url"];
        $dossier = "pochettes/";

        $nomPochette = sha1($data["titre"] . time());
        $data["image"] = "avatar.jpg";
        $toDelete = 0;
        if (!empty($_FILES['image']['tmp_name'])) {
          $tmp = $_FILES['image']['tmp_name'];
          $fichier = $_FILES['image']['name'];
          $extension = strrchr($fichier, '.');
          @move_uploaded_file($tmp, $dossier . $nomPochette . $extension);
          // Enlever le fichier temporaire chargé
          @unlink($tmp); //effacer le fichier temporaire
          $pochette = $nomPochette . $extension;
          $data["image"] = $pochette;
        }
        $msg = json_decode(newFilm($data, $conn),true);
        $films = json_decode(getAllMovies($conn),true);
      } else if ($postAction == "updateFilm") {
        $data['titre'] = '';
        if (isset($_POST["titre"]))  $data["titre"] = $_POST["titre"];
        if (isset($_POST["category_id"])) $data["category_id"] = $_POST["category_id"];
        if (isset($_POST["auteur"])) $data["auteur"] = $_POST["auteur"];
        if (isset($_POST["prix"])) $data["prix"] = $_POST["prix"];
        if (isset($_POST["duree"])) $data["duree"] = $_POST["duree"];
        if (isset($_POST["preview_url"])) $data["preview_url"] = $_POST["preview_url"];
        $dossier = "pochettes/";

        $nomPochette = sha1($data["titre"] . time());
        $data["image"] = "avatar.jpg";
        $toDelete = 0;
        if (!empty($_FILES['image']['tmp_name'])) {
          $tmp = $_FILES['image']['tmp_name'];
          $fichier = $_FILES['image']['name'];
          $extension = strrchr($fichier, '.');
          @move_uploaded_file($tmp, $dossier . $nomPochette . $extension);
          // Enlever le fichier temporaire chargé
          @unlink($tmp); //effacer le fichier temporaire
          $pochette = $nomPochette . $extension;
          $data["image"] = $pochette;
          $toDelete = 1;
        }
        $msg =
          json_decode(updateFilm($_POST["filmId"], $data, $conn, $toDelete),true);
        $films = json_decode(getAllMovies($conn),true);
      } else if ($postAction == "deleteFilm") {
        $msg = json_decode(deleteMovie($_POST["film_id"], $conn),true);
        $films = json_decode(getAllMovies($conn),true);
      }
      $filmListing = '<div class="col pt-2">
            <div class="row justify-content-center ">
              <div class="col-12">
                <div class="jumbotron bg-info">
                  <div class="row">
                    <div class="col main pt-0">
                      <h1 class=" d-none d-sm-block text-center text-white">
                        Liste des Films (' . count($films) . ')
                      </h1>
                    </div>
                  </div>
                </div>';
      if ($msg) {
        $filmListing .= '<div id="message">
                    <div class="alert alert-success" id="success-alert"> <strong> Success! </strong>"' . $msg . '
                "</div>';
      }
      $filmListing .= '<div class="container box">
                      <div class="row mb-4">
                          <div class="col-md-2 ml-auto">
                            <a href="#" onclick="addFilms()" class="btn btn-md btn-block btn-success text-uppercase m-2">
                              <i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter</a>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="table-responsive table-hover">
                              <table class="table table-striped">
                                <thead class="bg-info text-white">
                                  <tr>
                                    <th scope="col3">Pochette</th>
                                    <th scope="col3">Titre</th>
                                    <th scope="col3" width="100">Prix</th>
                                    <th scope="col3" width="100">Categorie</th>
                                    <th scope="col3" width="100">Realisateur</th>
                                    <th scope="col3" width="100">Duree</th>
                                    <th colspan="2" scope="col3" class="text-center">Action</th>
                                  </tr>
                                </thead>
                                <tbody>';
      foreach ($films as $film) {
        $filmListing .= '
                            <td><img src="pochettes/' . $film["image"] . '" height="100" /> </td>
                                  <td>' . $film["titre"] . '</td>
                                  <td class="text-center">' . $film["prix"] . ' $</td>
                                  <td class="text-center">' . $film["cat_title"] . '</td>
                                  <td class="text-center">' . $film["auteur"] . '</td>
                                  <td class="text-center">' . $film["duree"] . '</td>
                                  <td class="text-right">
                                    <a href="#" onclick="editFilm(' . $film["id"] . ')" class="btn
                                      btn-outline-info">
                                      <i class="fa fa-edit" aria-hidden="true"></i>
                                      Modifier
                                    </a>
                                  </td>
                                  <td class="text-right">
                                    <a href="#" onclick="deleteFilm(' . $film["id"] . ')" class="btn
                                      btn-outline-danger">
                                      <i class="fa fa-edit" aria-hidden="true"></i>
                                      Supprimer
                                    </a>
                                  </td></tr>';
      }
      $filmListing .= '</tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>';
    }
    echo json_encode($filmListing);
  }

  //Gestion des Categories
  if (($getAction == 'categories' || $postAction == 'addCategory' || $postAction == 'deleteCat' || $postAction == 'updateCategory')) {
    $msg = "";
    if ($postAction == "addCategory") {
      $msg = newCategory($_POST["catTitle"], $conn);
    } else  if ($postAction == "deleteCat") {
      $msg = deleteCategory($_POST["id"], $conn);
    }
    if ($postAction == "updateCategory") {
      $msg = updateCategory($_POST["catId"], $_POST["catTitle"], $conn);
    }
    $categories = getAllCategories($conn);
    $categories = json_decode( $categories,true);
    $categoryListing = '<div class="col pt-2">
        <div class="row justify-content-center ">
          <div class="col-12">
            <div class="jumbotron bg-info">
              <div class="row">
                <div class="col main pt-0">
                  <h1 class=" d-none d-sm-block text-center text-white">
                    Liste de Catégories (' . count($categories) . ')
                  </h1>
                </div>
              </div>
            </div>';
    if ($msg) {
      $categoryListing .= '<div id="message">
                    <div class="alert alert-success" id="success-alert"> <strong> Success! </strong>"' . json_decode( $msg,true) . '
                "</div>';
    }
    $categoryListing .= '<div id="message"></div>
            <div class="container box">
              <div class="row mb-4">
                <div class="col-md-2 ml-auto">
                  <a href="#" onclick="addCategory()" class="btn btn-md btn-block btn-success text-uppercase m-2">
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
                      <tbody>';
    foreach ($categories as $category) {
      $categoryListing .= '<tr>
                          <td>' . $category["titre"] . '</td>
                          <td class="text-right">
                            <a href="#" onclick="editCat(' . $category["id"] . ')" class="btn
                                        btn-outline-info">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Modifier
                                    </a>
                                  </td>
                                <td>
                                <a href="#" onclick="deleteCat(' . $category["id"] . ')" class="btn
                                        btn-outline-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        Supprimer
                                      </a>
                              </td>
                            </tr>';
    }
    $categoryListing .= '</tbody>
                          </table>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>';
    echo json_encode($categoryListing);
  }

  //Gestion du Panier
  if (($getAction == 'getPanier' || $getAction == 'deleteFromCart' || $getAction == 'viderPanier')) {
    $msg = "";
    if ($getAction == "deleteFromCart") {
      $msg = supprimerDuPanier($_GET["film_id"], $conn);
      $locations = getPanier($conn);
    }
    $total = 0;
    $grandTotal = 0;
    $locations = getPanier($conn);
    $locations = json_decode($locations,true);
    $panierListing = "";
    if (count($locations)) {
      $panierListing = '<section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Mon Panier de Locations</h1>
      </div>';
      if ($msg) {
        $panierListing .= '<div class="alert alert-success" id="success-alert"> <strong> Success! </strong>' . $msg . '</div>';
      }

      $panierListing .= '</section>
    <div class="container">
      <div class="row mb-4">
        <div class="col-md-4 text-left">
          <h4>(' . count($locations) . ') Films</h4>
        </div>
        <div class="col-md-5 text-right ">
          <div class="btn-group">
            <a href="index.php" class="btn btn-md btn-block btn-info text-uppercase m-2">
              <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Continuer de Louer</a>
            <a href="#" onclick="checkout()" class="btn btn-md btn-block btn-success text-uppercase m-2">
              Passer Votre commande <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            <a href="#" onclick="viderPanier()" class="btn btn-md btn-block btn-danger text-uppercase m-2"> <i class="fa fa-trash" aria-hidden="true"></i>
                Vider Panier</a>
          </div>
        </div>
      </div>
      <div class="row ">
        <div class="col-12">
          <div class="table-responsive table-hover  box">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Pochette</th>
                  <th scope="col">Titre</th>
                  <th scope="col" width="100">Quantite</th>
                  <th scope="col" width="100">Prix</th>
                  <th scope="col" width="200" class="text-right">Action</th>
                </tr>
              </thead>
              <tbody>';
      foreach ($locations as $location) {
        $final_price = $location["quantity"] * $location["prix"];

        $total += $final_price;

        $panierListing .= '<tr>
                  <td><img src="pochettes/' . $location["image"] . '" height="100" /> </td>
                  <td>' . $location["titre"] . '</td>
                  <td class="text-center">' . $location["quantity"] . '</td>
                  <td class="text-center">' . $final_price . ' $</td>
                  <td class="text-right">
                  <a href="#" onclick="deleteFromCart(' . $location["id"] . ')" class="btn btn-md btn-block btn-danger text-uppercase m-2"> <i class="fa fa-trash" aria-hidden="true"></i>
                Supprimer</a></td></tr>';
      }
      $panierListing .= '</tbody>
    </table>
    </div>
    <div class="row mb-4">
      <div class="col-md-2 ml-auto">
        <h4>Récapitulatif</h4>';
      $tvq = ($total * 9.975) / 100;
      $tps = ($total * 5) / 100;
      $grandTotal = $total + $tvq + $tps;
      $panierListing .= '<p> Sous-Total:$ ' . $total . '<br />
          TVQ: $' . round($tvq, 2) . '<br />
          TPS: $' . round($tps, 2) . '$<br />
          Total: $' . round($grandTotal, 2) . '<br />
          </p>
          </div>
          </div>
          </div>
          </div>';
    } else {
      $panierListing = '<section class="text-center">
      <div class="container text-center">
        <div class="row justify-content-center ">
          <div class="col-12" style="margin-top:10%;">
            <div class="jumbotron bg-panier">
              <h1 class="jumbotron-heading">Votre Panier de Locations est Vide</h1>
              <hr class="my-4">
              <p class="lead text-center ">
                <a class="btn btn-success btn-lg" href="index.php"> <i class="fa fa-arrow-circle-left"
                    aria-hidden="true"></i> Continuer de Louer</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>';
    }

    if ($getAction == "viderPanier") {
      viderPanier($conn);
      $panierListing = '<section class="text-center">
      <div class="container text-center">
        <div class="row justify-content-center ">
          <div class="col-12" style="margin-top:10%;">
            <div class="jumbotron bg-panier">
              <h1 class="jumbotron-heading">Votre Panier de Locations est Vide</h1>
              <hr class="my-4">
              <p class="lead text-center ">
                <a class="btn btn-success btn-lg" href="index.php"> <i class="fa fa-arrow-circle-left"
                    aria-hidden="true"></i> Continuer de Louer</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>';
    }
    echo json_encode($panierListing);
  }

  //Gestion de l'authetification
  if (($getAction == 'logout' || $postAction == "login" || $postAction == "register")) {
    if ($getAction == "logout") {
      session_destroy();
      echo json_encode("success");
    } else if ($postAction == "login") {
      echo
        login($_POST["email"], $_POST["password"], $conn);
    } else if ($postAction == "register") {
      echo register($_POST["name"], $_POST["email"], $_POST["password"], $conn);
    }
  }

  if ($getAction == "confirmer") {
    $locations = getPanier($conn);
    $locations = json_decode($locations,true);
    foreach ($locations as $location) {
      addToRentals($location["id"], $location["quantity"], $conn);
    }
    trashPanier($conn);
    $thanksPage = '<div class="container p-5 mt-5">
       <div class="jumbotron text-center box mt-5 ">
         <h1 class="display-3">Transaction Réussie !</h1>
         <p class="lead">Nous vous avons envoyer un <strong>email de confirmation</strong> avec les details de votre
           commande.</p>
         <hr>
       </div>
     </div>';
     echo json_encode($thanksPage);
  } elseif ($getAction == "locations") {
    $rentalListing = '<div class="col pt-2">
        <div class="row justify-content-center ">
          <div class="col-12">
            <div class="jumbotron bg-info">
              <div class="row">
                <div class="col main pt-0">
                  <h1 class=" d-none d-sm-block text-center text-white">
                    Liste des Location des Membres (' . count($rentals) . ')</h1>
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
                      <tbody>';
    foreach ($rentals as $rental) {
      $rentalListing .= '<tr> <td><img src="pochettes/' .
        $rental["image"] . '" height="100" /> </td><td>' . $rental["titre"] . '</td><td>' .
        $rental["quantity"] . '</td><td>' . $rental["prix"] . '</td><td class="text-center">' .
        ($rental["prix"] * $rental["quantity"]) . ' $</td> <td>' . $rental["member_name"] . '</td><td>'
        . $rental["member_email"] . '</td></tr>';
    }
    $rentalListing .= '</tbody>
      </table>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>';
    echo json_encode($rentalListing);
  } elseif ($getAction == "membres") {
    $membreListing = '
      <div class="col pt-2">
      <div class="row justify-content-center ">
        <div class="col-12">
          <div class="jumbotron bg-info">
            <div class="row">
              <div class="col main pt-0">
                <h1 class=" d-none d-sm-block text-center text-white">
                  Liste des membres (' . count($membres) . ')</h1></div></div></div>
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
                          <tbody>';
    foreach ($membres as $membre) {
      $membreListing .= '<tr><td>' . $membre["nom"]
        . '</td><td class="text-center">' . $membre["email"] . '</td>';
      if (!$membre["is_admin"]) {
        $membreListing .= '<td class="text-right">
                          <a href="#" onclick="deleteMembre(' . $membre["id"] . ')" class="btn
          btn-outline-danger">
          <i class="fa fa-trash" aria-hidden="true"></i>
          Supprimer
        </a>
        </td>';
      }
      $membreListing .= '</tr>';
    }
    $membreListing .= '</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
    echo json_encode($membreListing);
  } else if ($getAction == "home") {
    $welcomeSection = "";
    if (checkIfLogedIn() && !is_admin()) {
      $welcomeSection = '<div class="jumbotron">
            <div class="row m-5">
              <div class="col main">
                <h1 class="display-4 d-none d-sm-block">
                  <div class="row justify-content-center ">
                    <div class="col-12">
                      <div class="jumbotron bg-home">
                        <h1 class="display-4 text-center text-white"> Bienvenue ' . $_SESSION["email"] . '</h1>
                        <hr class="my-4">
                        <h4 class="text-center text-white mb-4">Creez vos locations de films</h4>
                        <p class="lead text-center ">
                          <a class="btn btn-primary btn-lg" href="#" onclick="panier()">Mon Panier</a>
                        </p>
                        </div>
                        </div>
                        </div>
                        </h1>
                        </div>
                        </div>
                        </div>';
    } elseif (checkIfLogedIn() && is_admin()) {
      $films = json_decode(getAllMovies($conn),true);
      $membres = json_decode(getAllMembers($conn),true);
      $categories = json_decode(getAllCategories($conn),true);
      $welcomeSection = '<div class="jumbotron bg-info">
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
                        <h1 class="display-4">' . count($membres) . '</h1>
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
                        <h1 class="display-4">' . count($films) . '</h1>
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
                            <h1 class="display-4">' . count($categories) . '</h1>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>';
    } else {
      $welcomeSection = '<div class="container">
      <div class="row justify-content-center ">
        <div class="col-12" style="margin-top:10%;">
          <div class="jumbotron bg-home">
            <h1 class="display-4 text-center text-white">Location de Films</h1>
            <hr class="my-4">
            <h4 class="text-center text-white mb-4">Creez Votre Compte ou connectez-vous pour pouvoir gerer vos
              locations de films</h4>
            <p class="lead text-center ">
              <a class="btn btn-primary btn-lg" href="login.php" role="button">Se Connecter</a>
            </p>
          </div>
        </div>
      </div>
    </div>';
    }
    echo json_encode($welcomeSection);
  }

  if ($postAction == "getFilmById") {
    $film = json_decode(getFilmById($_POST["filmId"], $conn),true);
    $filmPage = '<div class="row justify-content-center ">
  <div class="col-12">
    <div class="container login-container">
      <div class="row">
        <div class="col-md-10 login-form-1">
          <h3 class=" d-none d-sm-block text-center">
            Modifier Le Film : ' . $film["titre"] . '
          </h3>
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label>Titre</label>
                  <input type="text" name="titre" id="titre" class="form-control" value="' . $film["titre"] . '" />
                            <input type="hidden" name="filmId" id="filmId" class="form-control" value="' . $film["id"]
      . '" />
                          </div>
                         </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                              <label>Catégorie</label>
                              <select class="form-control" name="category_id" id="category_id">';
    foreach ($categories
      as $categorie) {
      $filmPage .= '<option value="' . $categorie["id"] . '"';
      if ($categorie["id"] == $film["category_id"]) {
        $filmPage .= '"selected"';
      }
      $filmPage .= '>' .
        $categorie["titre"] . '</option>';
    }
    $filmPage .= '</select>
                </div>
                <div class="col-md-6">
                  <label>Realisateur</label>
                  <input type="text" name="auteur" id="auteur" class="form-control" value="' . $film["auteur"] . '" />
                </div>
                </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Prix</label>
                      <input type="number" name="prix"  id="prix" class="form-control" value="' . $film["prix"] . '" />
                </div>
                <div class="col-md-6">
                  <label>Duree</label>
                  <input type="text" name="duree" id="duree" class="form-control" value="' . $film["duree"] . '" />
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
                      <input type="link" name="preview_url" id="preview_url" class="form-control" value="' .
      $film["preview_url"] . '" />
                </div>
                </div>
                </div>
                <div class="row">
                <a class="btnSubmit" href="#" onclick="putFilm()">Sauvegarder</a>
                </div>
                </form>
                </div>
                </div>
                </div>
                </div>
                </div>';
    echo json_encode($filmPage);
  } elseif ($postAction == "deleteMembre") {
    $msg = json_decode(deleteMember($_POST["id"], $conn));
    $membres = json_decode(getAllMembers($conn),true);
    $membreListing = '<div class="col pt-2">
      <div class="row justify-content-center ">
        <div class="col-12">
          <div class="jumbotron bg-info">
            <div class="row">
              <div class="col main pt-0">
                <h1 class=" d-none d-sm-block text-center text-white">
                  Liste des membres (' . count($membres) . ')
                </h1>
              </div>
            </div>
          </div>
          <div id="message">
            <div class="alert alert-success" id="success-alert"> <strong> Success! </strong>"' . $msg . '
        "</div>
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
                          <tbody>';
    foreach ($membres as $membre) {
      $membreListing .= '<tr><td>' . $membre["nom"]
        . '</td><td class="text-center">' . $membre["email"] . '</td>';
      if (!$membre["is_admin"]) {
        $membreListing .= '<td class="text-right">
                                                <a href="#" onclick="deleteMembre(' . $membre["id"] . ')" class="btn
                                btn-outline-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                Supprimer
                              </a>
                          </td>';
      }
      $membreListing .= '</tr>';
    }
    $membreListing .= '</tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>';
    echo json_encode($membreListing);
  } elseif ($postAction == "getCategoryById") {
    $cat = json_decode(getCategoryById($_POST["categoryId"], $conn),true);
    echo json_encode('<div class="row justify-content-center ">
          <div class="col-12">
            <div class="container login-container">
              <div class="row">
                <div class="col-md-10 login-form-1">
                  <h3 class=" d-none d-sm-block text-center">
                    Modifier La Catégorie :' . $cat["titre"] . '
                  </h3>
                  <div id="message"></div>
                  <form>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label>Titre</label>
                          <input type="text" name="titre" id="catTitle" class="form-control" value="' . $cat["titre"] . '" />
                          <input type="hidden" name="id" id="catId" class="form-control" value="' . $cat["id"] . '" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <a class="btnSubmit" href="#" onclick="putCat()">Savegarder</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>');
  }
}