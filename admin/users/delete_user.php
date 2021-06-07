<?php 

    require '../connect.php';
    $boss ="";


    if(!empty($_GET['id'])) {

        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) {

        $id = checkInput($_POST['id']);
    
        $db = Database::connect();

        $statement = $db->prepare('SELECT * FROM users WHERE id = ?');
        $statement->execute(array($id));

        $user = $statement->fetch();

        if($user['user_type'] != 'Boss'){

            echo 'DELETED';

            $statement = $db->prepare('DELETE FROM users WHERE id = ?');
            $statement->execute(array($id));

        }else{
            $boss = "On touche pas au Boss";
        }

        Database::disconnect();
        
        echo '<script> window.location = "../index.php?page=5"</script>';




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
                    <h1><strong>Suppression de l'Admin </strong></h1>
                    <?php 
                        if($boss){
                            echo '<div class="mb-3 alert alert-danger">'. $boss . '</div>'; 
                        }
                    ?>
                    <form class="form" role="form" action="delete_user.php" method="POST">
                        <input type="hidden" name="id" value="<?php  echo $id; ?>">
                        <p class="alert alert-warning">Voulez vous vraiment supprimer l'Admin ?</p>
                        <div class="form-actions">
                            <a  href="../index.php?page=5" class="btn btn-default">Non</a>
                            <button class="btn btn-danger" type="submit" role="form">Oui</button>
                        </div>

                    </form>
                </div>

            </div>       
        </div>
                
    </body>
</html>