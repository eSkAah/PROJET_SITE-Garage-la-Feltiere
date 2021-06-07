<div class="container-fluid">

    <div class="row">
        <img class="img-fluid" alt="responsive image" src="images/soldout.png" >
        <div class="title col-12 mt-3 mb-3 ">
            <h2><span>VOITURES VENDUES </span></h2>
        </div>
    

            <!-- Début de la zone de selection d'annonce -->
    
            <?php 
            require 'admin/connect.php';
            $db = Database::connect();
            $statement = $db->query('SELECT * FROM items WHERE category="voitures_vendues"');

            while($itm = $statement->fetch())

            {
                echo '<div class="car-cardbox ml-sm-5 mb-5  col-sm-2 col-12 card">';
                echo "<div class='card-img-top' style =\"background-image:url('images/voitures_vendues/". $itm['img'] ."')!important \" ></div>";
                echo '<div class="card-body">';
                echo '<div class="mt-1 mb-2"><strong>Véhicule :</strong>' . $itm['description'] . '</div>';
                echo '<div class="mt-1"><strong>Kilométrage :</strong> ' . $itm['miles'] . 'km</div>';
                echo '</div>';
                echo '</div>';

            }

            ?>

        </div>
    </div>
</div>         