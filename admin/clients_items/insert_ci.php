<?php 
    require '../connect.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    /*Debug Var*/
    $color = $colorError = $name = $nameError = $miles = $milesError = $immat = $immatError = $year = $yearError = $serial = $serialError = $motor = $motorError = $type = $typeError = $carb = $carbError =  " ";
    $isSuccess = "";


    if(!empty($_POST))
    {
    
        $name       = checkInput($_POST['name']);
        $miles      = checkInput($_POST['miles']);
        $immat      = checkInput($_POST['immat']);
        $year       = checkInput($_POST['year']);
        $serial     = checkInput($_POST['serial']);
        $motor      = checkInput($_POST['motor']);
        $color      = checkInput($_POST['color']);
        $marque       = checkInput($_POST['marque']);
        $carb       = checkInput($_POST['carb']);
        $model       = checkInput($_POST['model']);

        $isSuccess  = true;

        // On check si tous les champs sont PAS VIDE, sinon on affiche un message d'erreur  et on bloque le Form avec un isSuccess false

        if(empty($name))
        {
            $nameError = "Ce champs ne peut pas rester vide";
            $isSuccess = false;
        }

        if(empty($miles))
        {
            $milesError = "Ce champs ne peut pas rester vide";
            $isSuccess  = false;
        }

        if(empty($immat))
        {
            $immatError = "Ce champs ne peut pas rester vide";
            $isSuccess  = false;
        }

        if(empty($year))
        {
            $yearError = "Ce champs ne peut pas rester vide";
            $isSuccess = false;
        }

        if(empty($serial))
        {
            $serialError = "Ce champs ne peut pas rester vide";
            $isSuccess   = false;
        }

        if(empty($motor))
        {
            $motorError = "Ce champs ne peut pas rester vide";
            $isSuccess  = false;
        }

        if(empty($color))
        {
            $colorError = "Ce champs ne peut pas rester vide";
            $isSuccess  = false;
        }

        if(empty($marque))
        {
            $typeError = "Ce champs ne peut pas rester vide";
            $isSuccess = false;
        }

        if(empty($model))
        {
            $typeError = "Ce champs ne peut pas rester vide";
            $isSuccess = false;
        }

        if(empty($carb))
        {
            $carbError = "Ce champs ne peut pas rester vide";
            $isSuccess = false;
        }

        // Si tous les champs sont remplis, alors isSuccess sera TRUE

        if($isSuccess)
        {
            $data = [
                'client'       => $id,
                'ci_name'      => $name,
                'ci_miles'     => $miles,
                'ci_immat'     => $immat,
                'ci_year'      => $year,
                'ci_serial'    => $serial,
                'ci_motor'     => $motor,
                'ci_color'     => $color,
                'ci_marque'      => $type,
                'ci_model'      => $model,
                'ci_carb'      => $carb
            ];

            $db = Database::connect();

            // Définition de la requête

            $query = "INSERT INTO clients_items (";
            $count_data = count($data);
            foreach ($data as $key => $value)
            {
                $query .= $key;
                $count_data--;
                if ($count_data>0) $query .= ", ";
            }
            $query .= ") VALUES (";
            $count_data = count($data);
            foreach ($data as $key => $value)
            {
                $guillemets = $key != "ci_miles" && $key != "ci_year";
                if ($guillemets) $query .= "'";
                $query .= $value;
                $count_data--;
                if ($guillemets) $query .= "'";
                if ($count_data>0) $query .= ", ";
            }
            $query .= ");";

            $statment = $db->prepare($query);
            $statment->execute();

            echo '<script> window.location = "view_ci.php?id='. $id .'" </script>';

            Database::disconnect();
            
            
        }

    }


    /*Securité*/
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
            <title>Ajouter un véhicule client</title>
    </head>
    <body>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-12">
                    <h1><strong>Ajouter une nouvelle voiture client </strong></h1>
                    <?php
                        if($isSuccess){
                            echo '<span class="alert alert-success">Le véhicule à été ajouté avec succés</span>';
                        }
                    ?>
                    <hr>

                    <form class="form" role="form" action="insert_ci.php?id=<?php echo $id ?>" method="POST"> <!-- Action = Fichier destination de l'envoi par méthode POST -->

                        <div class="col-12 d-flex">
                            <div class="col-6 form-group">
                                <label for="name">Nom du véhicule : </label>
                                <input type="texte" class="form-control" name="name"  value="<?php echo $name ?>">
                                <span class="help-inline"><?php echo $nameError ?></span>
                            </div>
                            

                            <div class="col-6 form-group">
                                <label for="miles">Kilometrage : </label>
                                <input type="number" class="form-control"  name="miles"  value="<?php echo $miles ?>">
                                <span class="help-inline"><?php echo $milesError ?></span>
                            </div>
                        </div>

                        <div class="col-12 d-flex">
                            <div class="col-6 form-group">
                                <label for="immat">Immatriculation : </label>
                                <input type="texte"  class="form-control" name="immat"  value="<?php echo $immat ?>">
                                <span class="help-inline"><?php echo $immatError ?></span>
                            </div>

                            <div class="col-6 form-group">
                                <label for="year">Année mise en circulation : </label>
                                <input type="number"  class="form-control" name="year"  value="<?php echo $year ?>">
                                <span class="help-inline"><?php echo $yearError ?></span>
                            </div>
                        </div>


                        <div class="col-12 d-flex">
                            <div class="col-6 form-group">
                                <label for="serial">N° de série : </label>
                                <input type="texte"  class="form-control" name="serial" value="<?php echo $serial ?>">
                                <span class="help-inline"><?php echo $serialError ?></span>
                            </div>

                            <div class="col-6 form-group">
                                <label for="motor">Motorisation : </label>
                                <input type="texte" class="form-control" name="motor"  value="<?php echo $motor ?>">
                                <span class="help-inline"><?php echo $motorError ?></span>
                            </div>
                        </div>

                        <div class="col-12 d-flex">
                            <div class="col-6 form-group">
                                <label for="type">Marque : </label>
                                <input type="texte" class="form-control" name="marque" value="<?php echo $type ?>">
                                <span class="help-inline"><?php echo $typeError ?></span>
                            </div>

                            <div class="col-6 form-group">
                                <label for="type">Marque : </label>
                                <input type="texte" class="form-control" name="model" value="<?php echo $type ?>">
                                <span class="help-inline"><?php echo $typeError ?></span>
                            </div>

                            <div class="col-6 form-group">
                                <label for="carb">Carburant : </label>
                                <input type="texte" class="form-control" name="carb" value="<?php echo $carb ?>">
                                <span class="help-inline"><?php echo $carbError ?></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="col-6 form-group">
                                <label for="color">Couleur : </label>
                                <input type="texte" class="form-control" name="color"  value="<?php echo $color ?>">
                                <span class="help-inline"><?php echo $motorError ?></span>
                            </div>
                        </div>

                    <div class="form-actions">
                        <a class="btn btn-danger" href="view_ci.php?id=<?= $id ?>">Retour</a>
                        <button type="submit" class="btn btn-success" >Ajouter</button>
                    </div>

                    </form>
                </div>    
            </div>
        </div>     
    </body>
</html>