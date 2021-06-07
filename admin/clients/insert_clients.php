<?php 
    require '../connect.php';

    $nameError = $surnameError = $emailError = $addressError = $zipError = $cityError = $passwordError = $name = $surname = $email = $address = $zip = $city = $password = " ";
    if(!empty($_POST))
    {
        $name       = checkInput($_POST['name']);
        $surname    = checkInput($_POST['surname']);
        $email      = checkInput($_POST['email']);
        $address    = checkInput($_POST['address']);
        $zip        = checkInput($_POST['zip']);
        $city       = checkInput($_POST['city']);
        $password   = password_hash(checkInput($_POST['password']), PASSWORD_BCRYPT);

        $isSuccess  = true;
        $uploadSuccess = false;

        // On check si tous les champs sont PAS VIDE, sinon on affiche un message d'erreur  et on bloque le Form avec un isSuccess false

        if(empty($name))
        {
            $nameError = "Vous devez donner la description du véhicule";
            $isSuccess = false;
        }

        if(empty($surname))
        {
            $surnameError = " Vous devez indiquer un prix";
            $isSuccess = false;
        }

        if(empty($email))
        {
            $emailError = " Vous devez indiquer l'année";
            $isSuccess = false;
        }

        if(empty($address))
        {
            $addressError = " Vous devez compléter le Kilométrage";
            $isSuccess = false;
        }

        if(empty($city))
        {
            $cityError = " Vous devez selectionner une catégorie";
            $isSuccess = false;
        }

        if(empty($zip))
        {
            $zipError = " Vous devez selectionner une catégorie";
            $isSuccess = false;
        }

        if(empty($password))
        {
            $passwordError = " Vous devez selectionner une catégorie";
            $isSuccess = false;
        }

        /*
        if(empty($img))
        {
            $imgError = " Vous devez selectionner une image";
            $isSuccess = false;

        }else{
            $uploadSuccess = true;

        }*/


        // Si tous les champs sont remplis, alors isSuccess sera TRUE, donc on insert dans la BDD puis on deconnect de la BDD
        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO clients (name, surname, email, password, address, zip, city ) values (?,?,?,?,?,?,?)");
            $statement->execute(array($name,$surname,$email,$password,$address,$zip, $city));
            Database::disconnect();
            header("Location: ../index.php?page=4");
            
        }

    }


// Securité
    function checkInput($data) 
    {
        $data = trim($data); //Retire les blancs 'space' en début et fin de chaine de char
        $data = stripslashes($data); // Supprimes les  "\" 
        $data = htmlspecialchars($data); // Remplace les &, "", '',<, > par d'autres entités
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
            <title>Ajouter du contenu </title>
    </head>
    <body>
        <div class="mt-5 container admin">
            <div class="row">
                <div class=" col-sm-12">
                    <h1><strong>Ajouter un nouveau Client </strong></h1>
                    <hr>

                    <form class="form" role="form" action="insert_clients.php" method="POST" enctype="multipart/form-data"> <!-- Action = Fichier destination de l'envoi par méthode POST -->

                        <div class="form-group">
                            <label for="surname">Nom:</label>
                            <input type="texte" class="form-control" id="surname" name="surname"  value="<?php echo $surname ?>">
                            <span class="help-inline"><?php echo $surnameError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="name">Prénom :</label>
                            <input type="texte" class="form-control" id="name" name="name"  value="<?php echo $name ?>">
                            <span class="help-inline"><?php echo $nameError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="texte"  class="form-control" id="email" name="email"  value="<?php echo $email ?>">
                            <span class="help-inline"><?php echo $emailError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="address">Adresse :</label>
                            <input type="texte"  class="form-control" id="address" name="address"  value="<?php echo $address ?>">
                            <span class="help-inline"><?php echo $addressError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="zip">Code postal :</label>
                            <input type="number"  class="form-control" id="zip" name="zip" value="<?php echo $zip ?>">
                            <span class="help-inline"><?php echo $zipError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="city">Ville :</label>
                            <input type="texte" class="form-control" id="city" name="city"  value="<?php echo $city ?>">
                        
                            <span class="help-inline"><?php echo $cityError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe :</label>
                            <input type="texte" class="form-control" id="passsword" name="password" value="<?php echo $password ?>">
                            <span class="help-inline"><?php echo $passwordError ?></span>
                        </div>

                        <!-- Ajout verif mot de pass x2 -->


                    

                    <div class="form-actions">
                        <a class="btn btn-danger" href="../index.php">Retour</a>
                        <button type="submit" class="btn btn-success" >Valider</button>
                    </div>

                    </form>

                </div>    
            </div>
        </div>
        
    </body>
</html>