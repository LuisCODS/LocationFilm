 <?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  viderPanier($conn);
?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <title>Transaction Réussie | Films </title>
   <?php include_once("../includes/header.php"); ?>
   <link rel="stylesheet" href="../../css/table.css">
 </head>

 <body>
   <main role="main">
     <?php include_once("../includes/adminMenu.php"); ?>
     <div class="container p-5 mt-5">
       <div class="jumbotron text-center box mt-5 ">
         <h1 class="display-3">Transaction Réussie !</h1>
         <p class="lead">Nous vous avons envoyer un <strong>email de confirmation</strong> avec les details de votre
           commande.</p>
         <hr>
         <p class="lead">
           <a class="btn btn-primary btn-lg" href="dashboard.php" role="button">Visiter Mon Tableau de Bord</a>
         </p>
       </div>
     </div>
   </main>
 </body>

 </html>