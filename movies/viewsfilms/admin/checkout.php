 <?php
  session_start();
  include("../includes/db.php");
  if(!isset($_SESSION["email"])){
      header("location:../login.php");
  }
  $films = getAllMovies($conn);
  $membres = getAllMembers($conn);
?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
   <title>Paiement de Ma Commande | Films </title>
   <?php include_once("../includes/header.php"); ?>
   <link rel="stylesheet" href="../../css/table.css">
 </head>

 <body>
   <main role="main">
     <?php include_once("../includes/adminMenu.php"); ?>
     <section class="jumbotron text-center">
       <div class="container">
         <h1 class="jumbotron-heading">Paiement de Ma Commande</h1>
       </div>
     </section>
     <div class="container">
       <div class="row box">
         <div class="col-md-12">
           <form action="transactionReussie.php"  novalidate="">
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
             <button class="btn btn-primary btn-lg btn-block" type="submit">Confirmer</button>            
           </form>
         </div>
       </div>
     </div>
   </main>
   <?php include_once("../includes/footer.php");?>
 </body>

 </html>