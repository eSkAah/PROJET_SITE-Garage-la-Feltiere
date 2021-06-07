
<div class="container-fluid">
    <div class="row">

        <img class="img-fluid" alt="responsive image" src="images/voituresUSA.png" >
        <div class="title col-sm-6 offset-3  mt-3 mb-3">
            <h2><span>NOS VOITURES DISPONIBLES :</span></h2>
        </div>
    </div>

    <div class="row">
     
        <!-- Début de la zone barre de recherche -->

    
                    
                    
        <!-- Fin de la zone barre de recherche -->


        <!-- Début de la zone de selection d'annonce -->
        <?php 
            require 'admin/connect.php';
            $db = Database::connect();
            
            $statement = $db->query('SELECT * FROM items WHERE category="voitures"');

            while($itm = $statement->fetch())

            {
                echo '<div class="car-cardbox ml-sm-5 mb-5  col-sm-2 col-12 card">';
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