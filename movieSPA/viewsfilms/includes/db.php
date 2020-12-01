<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "bdfilms";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}



function getAllCategories($conn)
{
  try {
    $stmt = $conn->prepare('SELECT * FROM categories');
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While fetching the categories: " . $e->getMessage());
  }
}

function getAllMovies($conn)
{
  try {
    $stmt = $conn->prepare('SELECT f.*, c.titre As cat_title FROM films f Left JOIN categories c  ON f.category_id=c.id ORDER BY created_at');
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While fetching the movies: " . $e->getMessage());
  }
}

function getRentals($conn)
{
  try {
    $stmt = $conn->prepare('SELECT f.*, m.nom As member_name, m.email As member_email, r.quantity FROM films f JOIN rentals r ON f.id=r.film_id JOIN membres m ON m.id=r.membre_id');
    $stmt->execute();
    //print_r($stmt->fetchAll());
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While fetching the rentals: " . $e->getMessage());
  }
}

function addToRentals($film_id, $quantity, $conn)
{

  try {

    $membre_id = $_SESSION["membre_id"];

    $stmt = $conn->prepare("SELECT * FROM rentals WHERE film_id = ? AND membre_id = ?");
    $stmt->execute([$film_id, $membre_id]);
    $rental = $stmt->fetch();

    if ($rental) {
      $newQuantity = $quantity + $rental['quantity'];
      $update_query = $conn->prepare("UPDATE rentals SET quantity=?
                                         WHERE film_id = ? AND membre_id = ?");
      $update_query->execute([$newQuantity, $film_id, $membre_id]);
      $count = $update_query->rowCount();
      if ($count > 0) return  "Succès";
      else return  "Echec";
    } else {
      $query = $conn->prepare("insert into rentals set film_id=?, quantity=?,membre_id = ?");
      $query->execute([$film_id, $quantity, $membre_id]);
      $count = $query->rowCount();
      $count = $query->rowCount();
      if ($count > 0) return  "Succès";
      else return  "Echec";
    }
  } catch (PDOException $e) {
    die("Error While adding to rentals: " . $e->getMessage());
  }
}

function getAllMembers($conn)
{
  try {
    $stmt = $conn->prepare('SELECT * FROM membres ORDER BY created_at');
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While fetching the members: " . $e->getMessage());
  }
}

function getMoviesByCategory($slug, $conn)
{
  try {
    $stmt = $conn->prepare('SELECT f.*, c.titre As cat_title FROM films f Left JOIN categories c  ON f.category_id=c.id WHERE slug = ? ORDER BY created_at');
    $stmt->execute([$slug]);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While fetching the movies: " . $e->getMessage());
  }
}

function getPageCat($slug, $conn)
{
  try {
    $stmt = $conn->prepare('SELECT * FROM categories  WHERE slug = ?');
    $stmt->execute([$slug]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    die("Error While fetching the category: " . $e->getMessage());
  }
}

//Methode qui recoit les input du login.php
function login($email, $password, $conn)
{
  try {
    $stmt = $conn->prepare("SELECT * FROM membres WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION["email"] = $email;
      $_SESSION["membre_id"] = $user['id'];
      $_SESSION["is_admin"] = $user['is_admin'];
      return "Success";
    } else {
      return 'Email/Mot de passe est Erroné!';
    }
  } catch (PDOException $e) {
    die("Error While login the user: " . $e->getMessage());
  }
}

function register($name, $email, $password, $conn)
{
  try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("SELECT email FROM membres WHERE email = ?");
    $stmt->execute([$email]);
    $found = $stmt->fetchColumn();
    if ($found) {
      return 'Cet Email Existe deja !!!';
    } else {
      $query = $conn->prepare("insert into membres set nom=?, email=?, password=? ");
      $query->execute([$name, $email, $hash]);
      $count = $query->rowCount();
      if ($count > 0) {
        $id = $conn->lastInsertId();
        $_SESSION["email"] = $email;
        $_SESSION["membre_id"] = $id;
        $_SESSION["is_admin"]  = 0;
        return "Success";
      } else {
        return 'Une erreur est Survenue !!!';
      }
    }
  } catch (PDOException $e) {
    return ("Error While registering the user: " . $e->getMessage());
  }
}

function addToCart($film_id, $quantity, $conn)
{
  try {

    $membre_id = $_SESSION["membre_id"];

    $stmt = $conn->prepare("SELECT * FROM locations WHERE film_id = ? AND membre_id = ?");
    $stmt->execute([$film_id, $membre_id]);
    $location = $stmt->fetch();

    if ($location) {
      $newQuantity = $quantity + $location['quantity'];
      $update_query = $conn->prepare("UPDATE locations SET quantity=?
                                         WHERE film_id = ? AND membre_id = ?");
      $update_query->execute([$newQuantity, $film_id, $membre_id]);
      $count = $update_query->rowCount();

      if ($count > 0) {
        return  "<script type='text/javascript'>toastr.success('Produit ajouté au panier avec Succès!!!')</script>";
      } else {
        return  "<script type='text/javascript'>toastr.danger('Une erreur est Survenue !!!')</script>";
      }
    } else {
      $query = $conn->prepare("insert into locations set film_id=?, quantity=?,membre_id = ?");
      $query->execute([$film_id, $quantity, $membre_id]);
      $count = $query->rowCount();
      $count = $query->rowCount();
      if ($count > 0) {
        return  "<script type='text/javascript'>toastr.success('Produit ajouté au panier avec Succès!!!')</script>";
      } else {
        return  "<script type='text/javascript'>toastr.danger('Une erreur est Survenue !!!')</script>";
      }
    }
  } catch (PDOException $e) {
    die("Error While adding to cart: " . $e->getMessage());
  }
}

function redirectIfLogedIn()
{
  if (isset($_SESSION["email"])) {
    header("location:admin/dashboard.php");
  }
}

function checkIfLogedIn()
{
  if (isset($_SESSION["email"])) return true;
  else return false;
}

function is_admin()
{
  if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1) return true;
  else return false;
}

function getPanier($conn)
{
  try {

    $membre_id = $_SESSION["membre_id"];
    $stmt = $conn->prepare('SELECT f.*, l.quantity As quantity
       FROM films f Left JOIN locations l
       ON f.id=l.film_id
       WHERE membre_id = ?
       ORDER BY created_at ');

    $stmt->execute([$membre_id]);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While getting the cart: " . $e->getMessage());
  }
}

function viderPanier($conn)
{
  try {
    $membre_id = $_SESSION["membre_id"];
    $stmt = $conn->prepare("DELETE FROM locations WHERE membre_id = ?");
    $stmt->execute([$membre_id]);
    return "Success";
  } catch (PDOException $e) {
    return ("Error While trashing the cart: " . $e->getMessage());
  }
}


function trashPanier($conn)
{
  try {
    $membre_id = $_SESSION["membre_id"];
    $stmt = $conn->prepare("DELETE FROM locations WHERE membre_id = ?");
    $stmt->execute([$membre_id]);
  } catch (PDOException $e) {
    die("Error While trashing the cart: " . $e->getMessage());
  }
}

function supprimerDuPanier($film_id, $conn)
{
  try {
    $membre_id = $_SESSION["membre_id"];
    $stmt = $conn->prepare("DELETE FROM locations WHERE film_id = ? AND membre_id = ?");
    $stmt->execute([$film_id, $membre_id]);
    return "Film Supprimer du Panier avec Success";
  } catch (PDOException $e) {
    return ("Error While deleting from cart: " . $e->getMessage());
  }
}

function getFilmById($film_id, $conn)
{
  try {
    $stmt = $conn->prepare("SELECT * FROM films WHERE id = ?");
    $stmt->execute([$film_id]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    die("Error While getting a Film By Id: " . $e->getMessage());
  }
}

function newFilm($data, $conn)
{
  try {
    $stmt = $conn->prepare("INSERT INTO films (titre, category_id, auteur, prix,duree,image,preview_url) VALUES (?, ?, ?,?,?,?,?)");
    $stmt->execute([$data["titre"], $data["category_id"], $data["auteur"], $data["prix"], $data["duree"], $data["image"], $data["preview_url"]]);
    return "Film Creer Avec Success !";
  } catch (PDOException $e) {
    return ("Error While adding to Films: " . $e->getMessage());
  }
}

function updateFilm($id, $data, $conn, $toDelete)
{
  try {
    $query = $conn->prepare("SELECT * FROM films WHERE id = ?");
    $query->execute([$id]);
    $film =  $query->fetch();
    if ($toDelete) {
      if ($film['image'] !== "avatar.jpg") {
        unlink("pochettes/" . $film['image']);
      }
    } else {
      $data["image"] = $film['image'];
    }

    $stmt = $conn->prepare("UPDATE films SET  titre= ?, category_id= ?, auteur= ?, prix= ?,duree= ?,image= ?,preview_url= ? WHERE id = ?");
    $stmt->execute([$data["titre"], $data["category_id"], $data["auteur"], $data["prix"], $data["duree"], $data["image"], $data["preview_url"], $id]);
    return "Film modifier Avec Success";
  } catch (PDOException $e) {
    return ("Error While updating the Film: " . $e->getMessage());
  }
}
function deleteMovie($film_id, $conn)
{
  try {
    $query = $conn->prepare("SELECT * FROM films WHERE id = ?");
    $query->execute([$film_id]);
    $film =  $query->fetch();
    if ($film['image'] !== "avatar.jpg") {
      unlink("pochettes/" . $film['image']);
    }
    $stmt = $conn->prepare("DELETE FROM films WHERE id = ?");
    $stmt->execute([$film_id]);
    return "Film Bien Supprimer";
    //return  "<script type='text/javascript'>toastr.success('Votre Film a été Supprimé avec Succès !')</script>";
  } catch (PDOException $e) {
    return ("Error While deleting a movie: " . $e->getMessage());
  }
}

function deleteMember($member_id, $conn)
{
  try {
    $stmt = $conn->prepare("DELETE FROM membres WHERE id = ?");
    $stmt->execute([$member_id]);
    return  "Le Membre a été Supprimé avec Succès !";
  } catch (PDOException $e) {
    return "Error While deleting a movie: " . $e->getMessage();
  }
}

function deleteCategory($category_id, $conn)
{
  try {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    return  "La Catégorie a été Supprimée avec Succès !";
  } catch (PDOException $e) {
    return "Error While deleting a movie: " . $e->getMessage();
  }
}

function getCategoryById($id, $conn)
{
  try {
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  } catch (PDOException $e) {
    return ("Error While getting a Category By Id: " . $e->getMessage());
  }
}

function newCategory($titre, $conn)
{
  try {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titre)));
    $stmt = $conn->prepare("INSERT INTO categories (titre, slug) VALUES (?,?)");
    $stmt->execute([$titre, $slug]);
    return "Categorie Bien Creer";
  } catch (PDOException $e) {
    return "Error While adding to categories: " . $e->getMessage();
  }
}

function updateCategory($id, $titre, $conn)
{
  try {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titre)));
    $stmt = $conn->prepare("UPDATE categories SET titre = ?, slug = ? WHERE id = ?");
    $stmt->execute([$titre, $slug, $id]);
    return "Categorie Mise a  jour";
  } catch (PDOException $e) {
    return ("Error While updating the Category: " . $e->getMessage());
  }
}

function search($query, $conn)
{
  try {
    $keyword = '%' . $query . '%';
    $stmt = $conn->prepare('SELECT f.*, c.titre As cat_title FROM films f  Left JOIN categories c  ON f.category_id=c.id WHERE f.titre LIKE ?  ORDER BY created_at');
    $stmt->execute([$keyword]);
    return $stmt->fetchAll();
  } catch (PDOException $e) {
    die("Error While searching the Movie: " . $e->getMessage());
  }
}