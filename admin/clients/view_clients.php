<?php 
    require '../connect.php';
    
    if(isset($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);

    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT * FROM clients WHERE clients.id = ?');
    $statement->execute(array($id));
    $client = $statement->fetch();
    Database::disconnect();
    

    $imgNameError="";
    if(!empty($_POST))
    {
        
        $isSuccess      = true;
        $imgName        = checkInput($_POST['img-name']);
        $client         = $id;
        $date           = date('Y-m-d');
        $fileName       = $_FILES['img']['name'];  // $_FILES renvoi :  en tableau [name], [type], [error], [size]
        $imgExtension   = pathinfo($imgPath, PATHINFO_EXTENSION); // Extension de l'image qu'on va chercher via son chemin, et donne son extension, BONUS: Limiter les fichiers possible d'upload

        if(empty($imgName))
        {
            $imgNameError = "Vous devez donner la description de la facture";
            $isSuccess    = false;
        }

        if($isSuccess){

            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO billing (identification, bill_date, bill, client ) values (?,?,?,?)");
            $statement->execute(array($imgName, $date, $fileName, $client));
            Database::disconnect();

            if(isset($_FILES["img"]) && $_FILES["img"]["error"] == 0){

                /*$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");// Si verification type de fichier a faire
                $filetype = $_FILES["img"]["type"];// Si besoin blocage type de fichier
                $filesize = $_FILES["img"]["size"];// Si besoin limitation taille fichier*/

                move_uploaded_file($_FILES["img"]["tmp_name"], "../factures/" . $fileName);
                header('Location:../index.php?page=4');
            }

        }

    }

    /*Sécurité*/

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

        <title>Contenu BDD véhicules USA</title>
    </head>
    <body>
        <h1> Informations du Client</h1>
        <div class="container admin">
            <div class="row">

                <div class="col-12">
                    <h3><strong>Véhicule(s) de <?php echo $client['name']; ?> : </strong></h3>
                </div>


                <div class="col-sm-6 col-12">
                    <h3><strong>Numéro client : <?php echo $client['id']; ?> </strong></h3>
                    <hr>
                    <form>

                        <div class="form-group">
                            <label><strong>Prénom :</strong></label><br><?php  echo '  ' . $client['name']; ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Nom :</strong></label><br><?php  echo '  ' . $client['surname']; ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Email :</strong></label><br><?php  echo '  ' . $client['email']; ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Adresse :</strong></label><br><?php  echo '  ' . $client['address']; ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Code postale / Ville :</strong></label><br><?php  echo ' '. $client['zip'] . ' / ' . $client['city']; ?>
                        </div>

                    </form>
                </div>

                <div class="col-sm-6 col-12">
                    <h3>Liste des factures</h3>
                    <hr>
                    <table class="table table-light table-border">
                        <thead>
                            <tr>
                                <th>Identifiant</th>
                                <th>Date</th>
                                <th>Actions<th>      
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $db = Database::connect();
                            $statementBill = $db->query('SELECT * FROM billing WHERE billing.client =' . $id . '');
                            while($billing = $statementBill->fetch())
                            {
                                echo '<tr>';
                                echo '<td>' . $billing['identification'] . '</td>';
                                echo '<td>' . $billing['bill_date'] . '</td>';
                                echo '<td><a href="../factures/' . $billing['bill'].'" > Voir</a>';
                                echo'</tr>';
                            }
                            Database::disconnect();  
                            ?>

                        </tbody>
                    </table>
                    <form  action="view_clients.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                        
                    <div class="form-group">
                        <label for="img">Ajouter une pièce jointe :</label>
                        <input type="file"  id="img" name="img">
                        <label for="img-name">Nom de la facture :</label>
                        <input type="texte" id="img-name" name="img-name">
                        <span class="help-inline"><?php echo $imgNameError ?></span>
                    </div>

                    <div class="form-actions">
                        
                        <button type="submit" class="btn btn-success" >Valider</button>
                    </div>
            
                    </form>
                </div>

                <div>
                    <a class="btn btn-danger" href="../index.php?page=4">Retour</a>
                </div>
                <div>
                    <a class="ml-3 btn btn-info" href="../clients_items/view_ci.php?id=<?php echo $id ?>">Véhicule(s) client</a>
                </div>
                
            </div>
        </div>
    </body>
</html>