<?php
  include_once("../includes/db.php");
  $stmt = $conn->prepare('SELECT * FROM categories');
  $stmt->execute();
  $categories = $stmt->fetchAll();
   $errorMsg = "";
  try {
    if(isset($_POST["search"])){
      $films = search($_POST["query"], $conn);
    }
  }
  catch(PDOException $error){
    $errorMsg = $error->getMessage();
  }
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../home.php">Accueil Clients</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if(checkIfLogedIn() && is_admin()){ ?>
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="fa fa-tachometer" aria-hidden="true"></i>
          Tableau de Bord</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="allFilms.php">
          <i class="fa fa-film" aria-hidden="true"></i>
          Liste de Films</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="allMembers.php">
          <i class="fa fa-film" aria-hidden="true"></i>
          Membres</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="allCategories.php">
          <i class="fa fa-list" aria-hidden="true"></i>
          Cateogires</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="rental.php">
          <i class="fa fa-tasks" aria-hidden="true"></i>
          Locations</a>
      </li>
      <?php } else{ ?>
      <li class="nav-item">
        <a class="nav-link" href="../list.php">
          <i class="fa fa-film" aria-hidden="true"></i>
          Nos Films</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-list" aria-hidden="true"></i>
          Cateogires
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php foreach($categories as $category){ ?>
          <a class="dropdown-item"
            href="../category.php?slug=<?php echo $category["slug"]; ?>"><?php echo $category["titre"]; ?></a>
          <?php } ?>
        </div>
      </li>

      <form method="post" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" name="query" placeholder="Rechercher..." aria-label="Search"
          required>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Rechercher</button>
      </form>
      <?php } ?>
    </ul>
    <?php if(checkIfLogedIn()){ if(! is_admin()){ ?>
    <a class="navbar-brand" href="panier.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Mon
      Panier</a>
    <?php } ?>
    <a class="navbar-brand" href="#"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION["email"]; ?></a>
    <a class="navbar-brand" href="../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</a>
    <?php } else{ ?>
    <a class="navbar-brand" href="../register.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Devenir Membre</a>
    <a class="navbar-brand" href="../login.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Connexion</a>
    <?php }?>
  </div>
</nav>