<?php 
require('admin/connect.php');

if(isset($_SESSION['id'])){

    $id = $_SESSION['id'];
    
    //var_dump($_SESSION['password']);
}else{

    echo '<script>window.location="index.php?page=7"</script>';

}

$db= Database::connect();

$query = 'SELECT * 
            FROM clients 
            WHERE id= ?';

$statement = $db->prepare($query);
$statement->execute([$id]);

$client = $statement->fetch();

Database::disconnect();

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 style="text-align:center;"><span>Bonjour <?php echo $client['name'] ?> ! Bienvenue dans votre espace. </span></h2>
        </div>
    </div>

    
    <div class="row">
        <div class=" col-12 mb-3 text-center">
            <h3 class="mb-3">MES VEHICULES :</h3>
            <div class="row">
            <?php
            

            // Request SQL des véhicules liés à l'ID client récupéré das l'URL
            $db = Database::connect();
            $query = 'SELECT *
                FROM clients_items
                WHERE client= :id ';

            $req = $db->prepare($query);
            $req->execute(array(':id' => $_SESSION['id']));

            while($clients_items = $req->fetch()) 
            
            {

            echo '<div class="client-car col-sm-2 col-12 card bg-light ml-sm-3 mb-3" >';
            echo '<div class="card-header text-center bg-success"><strong>' . $clients_items['ci_name'] . '</strong></div>';
            echo '<div class="card-body bg-light text-left" >';   
            echo '<p class="card-title">Immatriculation : ' . $clients_items['ci_immat'] . '</p>';
            echo '<p class="card-text ">Kilométrage : ' . $clients_items['ci_miles'] . '</p>';
            echo '<p class="card-text">Premiere mise en circulation : ' . $clients_items['ci_year'] . '</p>';
            echo '<p class="card-text"> N° de série : ' . $clients_items['ci_serial'] . '</p>';
            echo '<p class="card-text">Motorisation : ' . $clients_items['ci_motor'] . '</p>';
            echo '<p class="card-text">Carburant : ' . $clients_items['ci_carb'] . '</p>';
            echo '<p class="card-text">Couleur : ' . $clients_items['ci_color'] . '</p>';
            
            echo '</div>';
            echo '</div>';

            }

            ?>
            </div>
        </div>

        <div class="col-sm-6 col-12 mb-3 text-center">
            <h3 class="mb-3">MES FACTURES / DEVIS : </h3>
            <table  class="table table-light table-border">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Date</th>
                        <th>Actions<th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    //TODO prepare ta requete
                    
                    $db = Database::connect();
                    $statementBill = $db->query('SELECT * FROM billing WHERE billing.client =' . $id . '');
                    while($billing = $statementBill->fetch())
                    {
                        echo '<tr>';
                        echo '<td>' . $billing['identification'] . '</td>';
                        echo '<td>' . $billing['bill_date'] . '</td>';
                        echo '<td><a href="admin/factures/' . $billing['bill'].'" > Voir</a>';
                        echo'</tr>';

                    }
                    Database::disconnect();  
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    


    <div class="row">
        <div class="col-sm-6 offset-sm-3 col-12 mt-2 mb-5 text-center ">
            <video class="video col-12" controls muted autoplay loop >
                    <source src="videos/e208.mp4"
                            type="video/mp4">
                    ERREUR ! Votre navigateur ne supporte pas les vidéos.
            </video>
        </div>
    </div>

        
                              
  
</div>