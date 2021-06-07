<?php 

    require '../connect.php';

    $success = "";

    if(!empty($_GET['id']) && !empty($_GET['ci'])) {

        $client_id  = checkInput($_GET['id']);
        $item_id    = checkInput($_GET['ci']);

        $db = Database::connect();

        $req = $db->prepare('SELECT * FROM clients_items WHERE id=? AND client=?');
        $req->execute(array($item_id, $client_id));

        $item = $req->fetch();

    }

    if(!empty($_POST)) {

        $client_id  = checkInput($_POST['client_id']);
        $item_id    = checkInput($_POST['item_id']);
    
        $db = Database::connect();

        $statement = $db->prepare('DELETE FROM clients_items WHERE id = ? AND client=? ');
        $statement->execute(array($item_id, $client_id));

        echo '<script> window.location="view_ci.php?id=' . $client_id .'"</script>';

        Database::disconnect();

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
        <h1> Base de données Voitures USA</h1>
        <div class="container admin">
            <div class="row">
                <div class="offset-3 col-sm-6" style="text-align:center;">
                    <h1><strong>Supprimer un item </strong></h1>
                    <form class="form" role="form" action="delete_ci.php" method="POST">
                        <input type="hidden" name="client_id" value="<?php  echo $client_id; ?>"> <!-- Récupère l'id de manière camouflé pour le POST -->
                        <input type="hidden" name="item_id" value="<?php  echo $item_id; ?>">
                        <p class="alert alert-warning">Voulez vous vraiment supprimer : <?php echo $item['ci_name'] ?> ?</p>
                        <div class="form-actions">
                            <a  href="view_ci.php?id=<?= $client_id ?>" class="btn btn-default">Non</a>
                            <button class="btn btn-danger" type="submit" role="form">Oui</button>
                        </div>
                        <span class="mt3"><?php echo $success ?></span>
                    </form>
                </div>     
            </div>       
        </div>         
    </body>
</html>