<?php 
    require '../connect.php';
    
    if(isset($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);


        $db = Database::connect();

        // Request SQL des infos Clients
        $statement = $db->prepare(
            'SELECT * 
            FROM clients 
            WHERE clients.id = ?');

        $statement->execute(array($id));
        $client = $statement->fetch();

        Database::disconnect();


    }


    /*Fonctions*/

    function checkInput($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

?>

    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link href="../../css/adminCustom.css" rel="stylesheet">

        <title>Véhicule(s) client</title>
    </head>

    <body>
        <h1>Véhicules de <?php echo $client['surname']; ?></h1>
            <div class="container admin">
                <div class="row">
                    <div class="col-12 mb-5 d-flex">
                        <h2>Liste des véhicules du client : </h2>
                        <a href='insert_ci.php?id=<?php echo $id ?>' class="ml-5 btn btn-success btn-lg"><i class="fas fa-plus"></i> Ajouter un véhicule</a>
                    </div>


                <?php

                 // Request SQL des véhicules liés à l'ID client récupéré das l'URL
                $db = Database::connect();
                $query = 'SELECT *
                    FROM clients_items
                    WHERE client= :id ';

                $req = $db->prepare($query);
                $req->execute(array(':id' => $id));

                while($clients_items = $req->fetch()) 
                
                {

                echo '<div class="card bg-light ml-3 mb-3" style="max-width: 18rem;">';
                echo '<div class="card-header"><strong>' . $clients_items['ci_name'] . '</strong></div>';
                echo '<div class="card-body">';   
                echo '<h5 class="card-title">Immatriculation : <br>' . $clients_items['ci_immat'] . '</h5>';
                echo '<p class="card-text">Kilométrage :' . $clients_items['ci_miles'] . '</p>';
                echo '<p class="card-text">Année mise en circulation :' . $clients_items['ci_year'] . '</p>';
                echo '<p class="card-text"> N° de série :' . $clients_items['ci_serial'] . '</p>';
                echo '<p class="card-text">Motorisation :' . $clients_items['ci_motor'] . '</p>';
                echo '<p class="card-text">Couleur :' . $clients_items['ci_color'] . '</p>';
                echo '<p class="card-text">Marque du véhicule :' . $clients_items['ci_marque'] . '</p>';
                echo '<p class="card-text">Modèle du véhicule :' . $clients_items['ci_model'] . '</p>';
                echo '</div>';
                echo '<a class="btn btn-danger" href="delete_ci.php?id='. $client['id'] . '&ci=' . $clients_items['id'] . '">SUPPRIMER</a>';
                echo '</div>';

                }

                ?>

                

            </div>
                <a class='ml-3 btn btn-danger' href="../index.php?page=4">Retour</a>
                <a class='ml-3 btn btn-info' href="../clients/view_clients.php?id=<?php echo $id ?>">Fiche Client</a>
            </div>

            
        
    </body>

</html>