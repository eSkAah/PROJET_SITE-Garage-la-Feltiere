<?php require 'admin/connect.php'; ?>
<section id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="mainPage mt-1 col-12">

        <img  class="img-fluid" alt="responsive image" src="images/lion.jpg">
        <h1 class=" text-center col-md-10 col-10">Vente de véhicules<br> Entretien Réparations</h1>

      </div>
    </div>
  </div>

</section>

  <section id="selects">
    <div class="container-fluid">
      <div class="row">

      <div class="title col-12">
          <h2 class="title"><span> NOTRE SÉLECTION DE VÉHICULES </span></h2>
        </div>
        
      </div> 
      
      <div class="test row">


<?php

$db = Database::connect();

$q = 'SELECT * FROM items WHERE active_item = 1';

$stm = $db->query($q);

while($itm = $stm->fetch()){


echo '<div class="cardbox mb-2  col-sm-2 col-12 card">';
echo "<div class='card-img-top' style =\"background-image:url('images/voitures/". $itm['img'] ."')!important \" ></div>";
echo '<div class="card-body">';
echo '<div class="mt-1 mb-2"><strong>Véhicule :</strong>' . $itm['description'] . '</div>';
echo '<div class="mt-1"><strong>Motorisation :</strong> ' . $itm['motorisation'] . '</div>';
echo '<div class="mt-1"><strong>Kilométrage :</strong> ' . $itm['miles'] . 'km</div>';
echo '<div class="mt-1 mb-2"><strong>Prix :</strong> ' . $itm['price'] . '€</div>';
echo '<a href="https://pros.lacentrale.fr/C037112/" class="mt-2 mb-3 btn btn-primary" role="button">Voir le véhicule</a>';
echo '</div>';
echo '</div>';
        

}
        
?>
        
      </div>
    </div>

  </section>

  <section id="chooseCar">
    <div class="container">
      <div class="row">

        <div class="title col-12">
          <h2><span>CHOISISSEZ LE TYPE DE VÉHICULE</span></h2>
        </div>

      </div>

      <div class="row">
        <div class="allCar col-md-5 ml-md-5  offset-1 col-10">
          <a href="https://pros.lacentrale.fr/C037112/"><img src="images/208.png">
        </div>

        <div class="usaCar col-md-5 ml-md-5  offset-1 col-10">
          <a href="index.php?page=2"><img  src="images/mustang2.png">
        </div>

      </div>

    </div>
  </section>

  <section id="services">
    <div class="container">
      <div class="row">
        <div class="title col-12">
            <h2><span>NOS SERVICES</span> </h2>
        </div>
      </div>

      <div class="row">
      
          <div class="mt-2 col-sm-4 ">
            <div class="card" >
                <a href="?page=4">
                <img class="card-img-top img-fluid" src="images/entretien2.jpeg"  alt="">
              <div class="service card-body">
                <h4 class="card-title"> Entretien</h4>
              </div>
            </div>
          </div>

          <div class="mt-2 col-sm-4 ">
            <div class="card" >
                <a href="?page=4">
                <img class="card-img-top img-fluid" src="images/carrosserie2.jpg"  alt="">
              <div class="service card-body">
                <h4 class="card-title"> Carrosserie</h4>
              </div>
            </div>
          </div>

         
          <div class="mt-2 col-sm-4 ">
            <div class="card">
                <a href="?page=4">
                <img class="card-img-top img-fluid" src="images/reparation2.jpg"  alt="">
              <div class="service card-body">
                <h4 class="card-title">Réparations</h4>
              </div>
            </div>
          </div>

        
        <div class="col-12 mt-5 mb-5" style="text-align:center;">
          <a href="?page=4"><button class="btn-lg btn-primary"> Voir tout nos services</button></a>
        </div>
      </div>
    </div>

  </section>

  <section id="presentation">

    <div class="container-fluid">
      <div class="row">
        <div class="title col-12">
          <h2><span>QUI SOMMES NOUS ?</span></h2>
        </div>
      </div>

      <div class="row">
        <div class="pres-img col-12">
          <img class="img-fluid mb-5" src="images/histoire2.png">
        </div>
      </div>
    </div>
    
    <div class="container">
        <div class="row">
          <p class="presTxt col-md-6 col-12">
          <strong>Présentation :</strong> <br><br>
            Le garage de la Feltière est une entreprise familiale de père en fils depuis 1988 au service du client.<br><br>
            La qualité, le sérieux, le professionnalisme et l'écoute sont les fondamentaux de cet établissement. <br><br>

            <i class="fas fa-angle-right"></i>  20min de la gare TGV de METZ <br><br>
            <i class="fas fa-angle-right"></i>  15min de la gare TGV de THIONVILLE<br><br>
            <i class="fas fa-angle-right"></i>  Une équipe de 14 personnes est là pour vous du Lundi au Vendredi
            de 8h à 12h et de 14h à 18h, et Samedi de 8h30 à 17h <br>
            ​
          </p>
          <p class="presTxt col-md-6 col-12">
            <strong>Services :</strong> <br><br>
            <i class="fas fa-angle-right"></i>  Achat-Vente de véhicules neuf.<br><br>
            <i class="fas fa-angle-right"></i>  Centre Occasions toutes marques achat vente reprise, stock permanent et stock fournisseurs.<br><br>
            <i class="fas fa-angle-right"></i>  Importation disponible sur commande stock fournisseurs IDCSF.<br><br>
            <i class="fas fa-angle-right"></i>  Ateliers, entretiens, suivis et réparations toutes marques. <br><br>
            <i class="fas fa-angle-right"></i>  Réparation carrosserie agréer assurances.<br><br>
            <i class="fas fa-angle-right"></i>  Importation homologation véhicule U.S <br><br>
          </p>
        </div>
      </div>
</section>



