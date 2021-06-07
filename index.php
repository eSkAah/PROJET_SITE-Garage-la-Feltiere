<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@600&display=swap" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    
    <title>GARAGE LA FELTIERE</title>
    
</head>

<body>
  
<div class="container-fluid p-0">
      <!--La navbar Bootstrap avec son style pré-définis, et le moment de l'expand/toggler-->
  <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-light">
    
    <div class="col-md-2 col-5">
      <img  class="img-fluid " alt="Responsive Logo" src="images/logoGF.png">
    </div>

    <div class="col-md-2 col-4">
      <p class="slogan">Garage de père en fils depuis 1988</p>
    </div>

  


    <!-- le Toggler Hamburger de Bootstrap-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Le menu de navigation du site Web-->
    <div class="col-md-8 collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="ml-md-5 nav-item active"><a class="nav-link" href="?page=1">ACCUEIL</a></li>
        <li class="nav-item active"><a class="nav-link" href="https://pros.lacentrale.fr/C037112/">OCCASIONS</a></li>
        <li class="nav-item active"><a class="nav-link" href="?page=2">VOITURES EN STOCK</a></li>
        <li class="nav-item active"><a class="nav-link" href="?page=3">VOITURES VENDUES</a></li>
        <li class="nav-item active"><a class="nav-link" href="?page=4">PRESTATIONS</a></li>
        <li class="nav-item active"><a class="nav-link" href="?page=6">CONTACT </a></li>
        <li class="ml-md-5 nav-item active"><a class="nav-link" href="?page=7"><i class="fas fa-user"></i><strong>  Mon compte  </strong></a></li>

        <?php 

        if(isset($_SESSION['id']) && isset($_SESSION['password']) ){
          echo '<li><a class="disconnect nav-link" href="disconnect.php"><i class="far fa-times-circle"></i><strong> Deconnexion</strong></a></li>';
        }else{
          echo '<li class="nav-item active"><a class="nav-link" href="?page=8"><i class="fas fa-clipboard-list"></i><strong> M\'inscrire </strong></a></li>';
        }
        ?>

      </ul>
    </div>
        
    
  </nav>
  </div>
      <!-- Debut du contenu des pages PHP appelés avec des includes-->
  
  
  <?php 

    if(isset($_GET['page'])) 
    {
    $page = htmlspecialchars($_GET['page']);

      if($page == 1) {
        include('accueil.php');
      }elseif($page == 2) {
        include('voituresUSA.php');
      }elseif($page == 3) {
        include('voituresVendues.php');
      }elseif($page == 4) {
        include('prestations.php');
      }elseif($page == 5){
        include('boutique.php');
      }elseif($page == 6) {
        include('contact.php');
      }elseif($page == 7) {
        include('login.php');
      }elseif($page == 8) {
        include('register.php');
      }elseif($page == 9) {
        include('espaceClient.php');
      }elseif($page == 10) {
        include('resetpw.php');
      }

    }else{
      include('accueil.php');
    }

  ?>
  
  <footer>

    <div class="container-fluid">
      <div class="row">
        <!-- Image de transition avant le footer-->
        <div class="transition">
          <img  class="img-fluid" alt="responsive image" src="images/bandeau.png">
        </div>

      <!-- Debut du footer -->
        <div class="footerLogo col-md-3  col-12 text-center">
          <img class="mt-5 img-fluid" alt="responsive image" src="images/logoGF.png">
          <div class="col-12 mt-2">Garage de père en fils depuis 1988</div>
        </div>

        <div class="col-md-3 mt-5 col-12 text-center">
          <div class="col-12 adress-footer">
            <h5><i class="fas fa-map-marked-alt"></i> ADRESSE :</h5>
            <p>17 Boucle des Dinandiers<br>
            57290 Fameck<br>
            Tél : +33 3 82 59 90 39<br>
            Mail : xxxxxx@hotmail.fr<br>
            </p>
          </div>
        </div>

        <div class="col-md-3 mt-5 col-12 text-center">
          <div class="col-12 hours-footer">
            <h5><i class="far fa-clock"></i> HORAIRES :</h5>
            <p>Ouvert du lundi au vendredi de 8h30<br>
              à 18h00, le samedi de 8h30 à 17h et<br>
              fermé le dimanche
            </p>
          </div>
        </div>

        <div class="col-md-3 mt-5 col-12 text-center">
          <h5><i class="fas fa-map-marker-alt"></i> OU NOUS TROUVER ? :</h5>
          <div class="map-responsive mb-3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3093.4525900025133!2d6.119329846084219!3d49.30910975601197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5302be6a63abac7b!2sGARAGE%20DE%20LA%20FELTIERE!5e0!3m2!1sfr!2sfr!4v1613651984410!5m2!1sfr!2sfr"
              width="400" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
              tabindex="0">
            </iframe>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>             
</body>

</html>