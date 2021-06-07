<?php 
    require '../connect.php';
    
    if(!empty($_GET['id'])){
        $id = checkInput($_GET['id']);
    }

    $nameError = $priceError = $motorisationError = $yearError = $milesError = $categoryError = $imgError = $name = $price = $year = $miles = $category = $img = "";// retirer l'erreur quand il trouve pas d'info sur les variables
    $isSuccess = "";
    $isImageUpdated = "";
    $uploadSuccess = "";

    if(!empty($_POST)) // Parcours une première fois la page pour voir si $_POST n'est PAS VIDE != de isset !! 
    {
        $name       = checkInput($_POST['name']);
        $price      = checkInput($_POST['price']);
        $year       = checkInput($_POST['year']);
        $miles      = checkInput($_POST['miles']);
        $motorisation = checkInput($_POST['motorisation']);
        $category   = checkInput($_POST['category']);
        $img        = checkInput($_FILES['img']['name']);  // $_FILES Super global qui permet de récupérer un fichier qu'on upload dans un tableau grâce à enctype="multipart/form-data"
        $imgPath    = '../../images/'. $category .'/'. basename($img);
        $directoryPath   ='../../images/'. $category . '/';
        $imgExtension = pathinfo($imgPath, PATHINFO_EXTENSION); // Extension de l'image qu'on va chercher via son chemin, et donne son extension, BONUS: Limiter les fichiers possible d'upload
        
        $isSuccess  = true;
        $uploadSuccess =false;

        // On check si tous les champs sont PAS VIDE, sinon on affiche un message d'erreur  et on bloque le Form avec un isSuccess false

        if(empty($name))
        {
            $nameError = " Vous devez donner la description du véhicule";
            $isSuccess = false;
        }
        if(empty($price))
        {
            $priceError = " Vous devez indiquer un prix";
            $isSuccess = false;
        }
        if(empty($year))
        {
            $yearError = " Vous devez indiquer l'année";
            $isSuccess = false;
        }
        if(empty($miles))
        {
            $milesError = " Vous devez compléter le Kilométrage";
            $isSuccess = false;
        }
        if(empty($motorisation))
        {
            $motorisationError = " Vous devez indiquer la motorisation";
            $isSuccess = false;
        }
        if(empty($category))
        {
            $categoryError = " Vous devez selectionner une catégorie";
            $isSuccess = false;
        }
        if(empty($img))
        {
            $isImageUpdated = false;
        }else{
            
            $uploadSuccess = true;
            $isImageUpdated = true;
            unlink($imgPath);

            if( $imgExtension != "jpg" && 
                $imgExtension !="png" &&
                $imgExtension !="jpeg" &&
                $imgExtension !="gif" &&
                $imgExtension != "JPG" && 
                $imgExtension !="PNG" &&
                $imgExtension !="JPEG" &&
                $imgExtension !="GIF" )
            {
                $imgError = "Veuillez selectionner un fichier au format : .jpg, .jpeg, .png, .gif";
                $uploadSuccess = false;
            }

            if(file_exists($imgPath))
            {
                $imgError = "Le fichier éxiste déja";
                $uploadSuccess = false;
            }

            if($_FILES["img"]["size"] > 5000000)
            {
                $imgError = "Fichier trop lourd ( < 500KB )";
                $uploadSuccess = false;
            }

            
            if($uploadSuccess)
            {
                move_uploaded_file($_FILES["img"]["tmp_name"], "../../images/". $category ."/" . $img);
            }

        }

        if(($isSuccess && $isImageUpdated && $uploadSuccess ) || ($isSuccess && !$isImageUpdated )) 
        {
            $db = Database::connect();
    
            if($isImageUpdated) {
                
                $statement = $db->prepare("UPDATE items set img = ?, description = ?, price = ?, year=?, miles=?, motorisation=?, category=? WHERE id= ?");
                $statement->execute(array($img,$name,$price,$year,$miles,$motorisation,$category, $id));
                header('Location: ../index.php?page=2');
                
            }else{
                echo $motorisation;
                $statement = $db->prepare("UPDATE items set description=? ,price=? ,year=? ,miles=?,motorisation=?, category=? WHERE id= ?");
                $statement->execute(array($name,$price,$year,$miles,$motorisation,$category, $id));
                
                header('Location: ../index.php?page=2');


            }
            Database::disconnect();
            
            }elseif($isImageUpdated && !$uploadSuccess)
            {
                $db = Database::connect();
                $statement = $db->prepare("SELECT img FROM items WHERE id= ?");
                $statement->execute(array($id));
                $item = $statement->fetch();
                

                $img = $item['img'];
        
                Database::disconnect();
                
            }
        

    }else{  // SI $_POST est bien VIDE, et il l'est au premier passage car nous passons par le bouton MODIFIER donc pas de method $_POST ALORS : les Variables prennent ces valeurs 
     
            $db = Database::connect();
            $statement = $db->prepare('SELECT * FROM items WHERE id = ?');
            $statement->execute(array($id));
            $item = $statement->fetch();

            $name       = $item['description'];
            $price      = $item['price'];
            $year       = $item['year'];
            $miles      = $item['miles'];
            $motorisation      = $item['motorisation'];
            $category   = $item['category'];
            $img        = $item['img'];
            
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

        <title>Update item</title>
    </head>

    <body>
        <h1> Mise à jour d'un Item de la Base de données</h1>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Visualisation de l'item </strong></h1>
                    <hr>
                    <form class="form" role="form" action="<?php echo 'update.php?id='. $id; ?>" method="POST" enctype="multipart/form-data"> <!-- Action = Fichier destination de l'envoi par méthode POST -->

                        <div class="form-group">
                            <label for="name">Description :</label>
                            <input type="texte" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name ?>">
                            <span class="help-inline"><?php echo $nameError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="price">Prix :</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price ?>">
                            <span class="help-inline"><?php echo $priceError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="year">Année :</label>
                            <input type="number" step="1" class="form-control" id="year" name="year" placeholder="Année" value="<?php echo $year ?>">
                            <span class="help-inline"><?php echo $yearError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="miles">Kilométrage :</label>
                            <input type="number" class="form-control" id="miles" name="miles" placeholder="Kilométrage" value="<?php echo $miles ?>">
                            <span class="help-inline"><?php echo $milesError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="motorisation">Motorisation :</label>
                            <input type="texte" class="form-control" id="motorisation" name="motorisation" placeholder="motorisation" value="<?php echo $motorisation ?>">
                            <span class="help-inline"><?php echo $motorisationError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="category">Catégorie :</label>
                            <select class="form-control" id="category" name="category">
                                <?php 
                                    $db = Database::connect();
                                    foreach($db->query('SELECT * FROM categories') as $row)
                                    {
                                        if($row['name'] == $category){
                                            echo '<option selected="selected" value="' . $row['name'] . '">' . $row['name'] .'</option>';
                                        }else{
                                            echo '<option value="' . $row['name'] . '">' . $row['name'] .'</option>';
                                        }

                                    }
                                    Database::disconnect();

                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError ?></span>
                        </div>

                        <div class="form-group">
                            <label>image actuelle :</label>
                            <p><?php echo $img ?></p>
                            <label for="img">Selectionner une image :</label>
                            <input type="file"  id="img" name="img"><br>
                            <span class="help-inline"><?php echo $imgError ?></span>
                        </div>

                        <div class="form-actions">
                            <a class="btn btn-danger" href="../index.php?page=2">Retour</a>
                            <button type="submit" class="btn btn-success" >Modifier</button>
                        </div>
                    </form> 
                </div>

                <div class="col-sm-6">

                    <div class="thumbnail">
                        <img  style="width:100%; heigth:400px;" src="<?php echo '../../images/' . $category . '/' .  $img ?>">
                    </div>
                    
                </div>

            </div>
        </div>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    </body>

</html>