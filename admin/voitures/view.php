<?php 
    require '../connect.php';

    if(isset($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);

    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT *
                                FROM items
                                WHERE items.id = ?');

    $statement->execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();


    
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

        <title>Administrateur - Base de données véhicules</title>
    </head>

    <body>
        <h1> Base de données Véhicules</h1>
            <div class="container admin">
                <div class="row">
                    <div class="col-sm-6">
                        <h1><strong><?php echo $item['description']?></strong></h1>
                        <hr>
                        <form>

                            <div class="form-group">
                                <label>Motorisation :</label><br><?php  echo '  ' . $item['motorisation'] . 'Km'; ?>
                            </div>

                            <div class="form-group">
                                <label>Prix :</label><br><?php  echo '  ' . number_format((float)$item['price'],2,',','.') . '€'; ?>
                            </div>

                            <div class="form-group">
                                <label>Année :</label><br><?php  echo '  ' . $item['year']; ?>
                            </div>

                            <div class="form-group">
                                <label>Kilométrage :</label><br><?php  echo '  ' . $item['miles'] . 'Km'; ?>
                            </div>



                            <div class="form-group">
                                <label> Image :</label><br><?php  echo '  ' . $item['img']; ?>
                            </div>

                        </form>

                        <div class="form-actions">

                        <?php
                        if($item['category'] == "voitures"){

                            echo '<a class="btn btn-danger" href="../index.php?page=2">Retour</a>';

                        }else{

                            echo '<a class="btn btn-danger" href="../index.php?page=3">Retour</a>';

                        }
                        ?>

                            
                        </div>
                    </div>


                    <div class="col-sm-6 mt-5">

                        <div class="thumbnail">
                            <img  style="width:100%;" src="<?php echo '../../images/' . $item['category'] . '/' .  $item['img'] ?>";>
                        </div>
                        
                    </div>

                      


                </div>

            </div>
        





    </body>





</html>