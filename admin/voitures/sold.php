<?php 

    require '../connect.php';

    $success="";

    if(!empty($_GET['id'])) {

        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) {

        
        $id = checkInput($_POST['id']);
        $cat = "voitures_vendues";
        $acti = 0;

        
        
        $db = Database::connect();


        $req = $db->prepare('UPDATE items set category = ?, active_item = ? WHERE id = ?');
        $req->execute(array($cat, $acti, $id));

        $statement = $db->prepare('SELECT * FROM items WHERE id = ?');
        $statement->execute(array($id));
        $item = $statement->fetch();

        $filePath = '../../images/voitures/'. $item['img'];
        $newFilepath = '../../images/' . $item['category'] . '/' . $item['img'];
        
        copy($filePath, $newFilepath);
        unlink($filePath);

        Database::disconnect();

        if($item['category'] == "voitures"){

            echo '<script> window.location = "../index.php?page=2"</script>';

        }else{

            echo '<script> window.location = "../index.php?page=3"</script>';

        }



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
                        <h1><strong>Véhicule Vendu? </strong></h1>
                    
                        <form class="form" role="form" action="sold.php" method="POST">
                            <input type="hidden" name="id" value="<?php  echo $id; ?>">
                            <p class="alert alert-warning">Transférer ce véhicule dans "Voitures Vendues" ?</p>
                            <div class="form-actions">
                                <a  href="../index.php" class="btn btn-default">Non</a>
                                <button class="btn btn-danger" type="submit" role="form">Oui</button>
                            </div>

                            <span class="mt3"><?php echo $success ?></span>

                        </form>
                        
                    </div>

                    </div>
                </div>       
            </div>
                
    </body>





</html>