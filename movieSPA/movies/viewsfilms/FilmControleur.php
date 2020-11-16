<?php
 session_start();
  include("includes/db.php");
  if(isset($_GET['action']) && $_GET['action'] == 'loadfilms'){
    $films = getAllMovies($conn);
    $header =null;
  }else if(isset($_GET['action']) && $_GET['action'] == 'getFilmsByCategory'){
    $slug = $_GET['slug'];
    $catTitre = $_GET['catTitre'];
    $films = getMoviesByCategory($slug,$conn);
    $header = '<div class="alert alert-success" role="alert"><h1 class="jumbotron-heading"> ('.count($films).') Films dans la catégorie: '.$catTitre.'</h1></div>';
}

$formatFilms ='<div class="album py-5 bg-light">
  <div class="container">
  '.$header.'
    <div class="row">';
      if (!empty($films)){
      foreach($films as $film){
      $formatFilms .='<div class="movie-card">
        <div class="movie-header" style="background-image:url(pochettes/'.$film["image"].');">
          <div class="header-icon-container">
            <a href="'.$film["preview_url"].'" data-lity>
              <i class="header-icon fa fa-play" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="movie-content">
          <div class="movie-content-header">
            <h3 class="movie-title text-center">'.$film["titre"].'</h3>
            <div class="imax-logo"></div>
          </div>
          <div class="movie-info">
            <div class="info-section">
              <label>Auteur</label>
              <span>'.$film["auteur"].'</span>
            </div>
            <div class="info-section">
              <label>Categorie</label>
              <span>'.$film["cat_title"].'</span>
            </div>
            <div class="info-section">
              <label>Duree</label>
              <span>'.$film["duree"].'</span>
            </div>
            <div class="info-section">
              <label>Prix</label>
              <span>'.$film["prix"].' $</span>
            </div>
          </div>';

          if(checkIfLogedIn()){
          $formatFilms .='<form id="myForm" method="post">
            <div class="row mt-3">
              <div class="col-md-6">
                <input type="hidden" name="film_id" value="'.$film["id"].'">
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

          $formatFilms .='
        </div>
      </div>';
      }
      $formatFilms .='</div>
  </div>
</div>';
}else{
$formatFilms ='<div class="alert alert-danger" role="alert">
  <h1 class="jumbotron-heading">Aucun Film.</h1>
</div>';
}
echo $formatFilms;
?>