<?php 

    require '../connect.php';

    if(!empty($_GET['id'])) {

        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) {

        $id = checkInput($_POST['id']);
    
        $db = Database::connect();

        $statement = $db->prepare('DELETE FROM clients_items WHERE client = ?');
        $statement->execute(array($id));

        $statement = $db->prepare('DELETE FROM billing WHERE client = ?');
        $statement->execute(array($id));

        $statement = $db->prepare('DELETE FROM clients WHERE id = ?');
        $statement->execute(array($id));




        Database::disconnect();
        header("Location: ../index.php?page=4");  // Si tout passe, alors tu retourne a l'index après avoir éffacé




    }
      
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
        <h1> Suppression Client</h1>
            <div class="container admin">
                <div class="row">
                    <div class="offset-3 col-sm-6" style="text-align:center;">
                        <h1><strong>Supprimer le client </strong></h1>
                    
                        <form class="form" role="form" action="delete_clients.php" method="POST">
                            <input type="hidden" name="id" value="<?php  echo $id; ?>">
                            <p class="alert alert-warning">Voulez vous vraiment supprimer le client?</p>
                            <div class="form-actions">
                                <a  href="../index.php?page=4" class="btn btn-default">Non</a>
                                <button class="btn btn-danger" type="submit" role="form">Oui</button>
                            </div>

                        </form>
                        
                    </div>

                    </div>
                </div>       
            </div>
                
    </body>





</html>