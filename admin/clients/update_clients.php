<?php 
    require '../connect.php';
    
    if(!empty($_GET['id'])){
        $id = checkInput($_GET['id']);
    }

    $error = "";
    $isSuccess = "";
    $editSuccess = "";


    if(!empty($_POST)) // Si $_POST est recu avec de la donnée
    {
        $name       = checkInput($_POST['name']);
        $surname    = checkInput($_POST['surname']);
        $email      = checkInput($_POST['email']);
        $address    = checkInput($_POST['address']);
        $zip        = checkInput($_POST['zip']);
        $city       = checkInput($_POST['city']);


        // On check si tous les champs sont PAS VIDE, sinon on affiche un message d'erreur  et on bloque le Form avec un isSuccess false

        if( empty($surname) ||
            empty($name) ||
            empty($email) ||
            empty($address) ||
            empty($zip) ||
            empty($city)
            )
        {
            $error = "Tous les champs du formulaire doivent être complétés";
            $isSuccess = false;
        }else{

            $isSuccess = true;

        }

        if($isSuccess)
        {

            // Essai nouvelle structure de requete SQL
        $db = Database::connect();

        $data = [
            'id'      => $id,
            'surname' => $surname,
            'name'    => $name, 
            'email'   => $email, 
            'address' => $address, 
            'zip'     => $zip, 
            'city'    => $city, 
        ];

        $query = 'UPDATE clients 
                    
                    set surname = :surname,
                    name        = :name,
                    email       = :email,
                    address     = :address,
                    zip         = :zip,
                    city        = :city
                    WHERE id    = :id
                        ';

        $statement = $db->prepare($query);
        $statement->execute($data);


        }

    }else{  // SI $_POST est bien VIDE, et il l'est au premier passage car nous passons par le bouton MODIFIER donc pas de method $_POST ALORS : les Variables prennent ces valeurs 
     
            $db = Database::connect();

            $statement = $db->prepare('SELECT * 
                                        FROM clients 
                                        WHERE id = ?'); 
            $statement->execute(array($id));

            $client = $statement->fetch();

            $surname       = $client['surname'];
            $name          = $client['name'];
            $email         = $client['email'];
            $password      = $client['password'];
            $address       = $client['address'];
            $zip           = $client['zip'];
            $city          = $client['city'];
            
            Database::disconnect();

        }
    

        /* Securité */
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
        <title>Update item</title>
    </head>

    <body>
        <h1> Modifier les informations du client</h1>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-12">
                    <h1><strong>Fiche client : </strong></h1>
                    <span class="help-inline"> <?php echo $error ?></span>
                    <?php
                        if($isSuccess){
                            echo '<div class="text-center alert alert-success">Le fichier client à été mis à jour avec succès</div>';
                        }
                    ?>
                    <hr>
                    <form class="form" role="form" action="<?php echo 'update_clients.php?id='. $id; ?>" method="POST" enctype="multipart/form-data"> <!-- Action = Fichier destination de l'envoi par méthode POST -->

                        <div class="col-12 d-flex">

                            <div class="form-group">
                                <label for="surname">Nom :</label>
                                <input type="texte" class="form-control" name="surname" placeholder="Nom" value="<?php echo $surname ?>"> 
                            </div>

                            <div class="ml-4 form-group">
                                <label for="name">Prenom :</label>
                                <input type="texte" class="form-control" name="name" placeholder="Prénom" value="<?php echo $name ?>">
                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group">
                                <label for="email">Email :</label>
                                <input size="50" type="texte" class="form-control" name="email" placeholder="Email" value="<?php echo $email ?>">  
                            </div>

                        </div>

                        <div class="col-6 d-flex">

                            <div class="form-group">
                                <label for="address">Adresse postale :</label>
                                <input type="texte" class="form-control" name="address" placeholder="Adresse" value="<?php echo $address ?>"> 
                            </div>

                        
                            <div class="ml-4 form-group">
                                <label for="zip">Code postale :</label>
                                <input type="texte" class="form-control" name="zip" placeholder="Code postale" value="<?php echo $zip ?>">
                            </div>

                        </div>


                        <div class="col-4">
                            <div class="form-group">
                                <label for="city">Ville :</label>
                                <input type="texte" class="form-control" name="city" placeholder="Ville" value="<?php echo $city ?>">
                            </div>
                        </div>


                        <div class="form-actions">
                            <a class="btn btn-danger" href="../index.php?page=4">Retour</a>
                            <button type="submit" class="btn btn-success" >Modifier</button>
                        </div>

                    </form> 
  
                </div>
            </div>
        </div>
    
    </body>

</html>