<?php 
    require '../connect.php';

    $nameError = $motorisationError = $priceError = $yearError = $milesError = $categoryError = $imgError = $name = $price = $year = $miles = $category = $img = " ";
    if(!empty($_POST))
    {
        $name       = checkInput($_POST['name']);
        $price      = checkInput($_POST['price']);
        $year       = checkInput($_POST['year']);
        $miles      = checkInput($_POST['miles']);
        $motorisation      = checkInput($_POST['motorisation']);
        $category   = checkInput($_POST['category']);
        $img        = $_FILES['img']['name'];  // $_FILES renvoi :  en tableau [name], [type], [error], [size]
        $imgPath    = '../../images/' . basename($img);
        $imgExtension = pathinfo($imgPath, PATHINFO_EXTENSION); // Extension de l'image qu'on va chercher via son chemin, et donne son extension, BONUS: Limiter les fichiers possible d'upload
        $isSuccess  = true;
        $uploadSuccess = false;

        /*echo $name;
        echo $price;
        echo $year;
        echo $miles;
        echo $category;
        echo $img;*/

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

        if(empty($category))
        {
            $categoryError = " Vous devez selectionner une catégorie";
            $isSuccess = false;
        }

        if(empty($motorisation))
        {
            $categoryError = " Vous devez selectionner une catégorie";
            $isSuccess = false;
        }

        if(empty($img))
        {
            $imgError = " Vous devez selectionner une image";
            $isSuccess = false;

        }else{
            $uploadSuccess = true;

        }


        // Si tous les champs sont remplis, alors isSuccess sera TRUE, donc on insert dans la BDD puis on deconnect de la BDD
        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (img,description,price,year,miles,motorisation,category) values (?,?,?,?,?,?,?)");
            $statement->execute(array($img,$name,$price,$year,$miles,$motorisation,$category));
            Database::disconnect();



            if(isset($_FILES["img"]) && $isSuccess = true){

               /*   
            $filetype = $_FILES["img"]["type"];// Si besoin blocage type de fichier
            $filesize = $_FILES["img"]["size"];// Si besoin limitation taille fichier
                
                if ($filetype != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg"){
                    $imgError = "Utilisez un format de fichier tel que jpg, png, jpeg !";
                    $isSucces = false;
                    }
                    if ($filesize > 10000000) {
                    $imgError = "Image trop volumineuse !";
                    $isSucces = false;
                }*/

                
                move_uploaded_file($_FILES["img"]["tmp_name"], "../../images/". $category ."/" . $img);
                header("Location: ../index.php");
                
            }
            
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
        <h1> Ajouter du contenu </h1>
        <div class="container admin">
            <div class="row">
                <div class="col-sm-12">
                    <h1><strong>Ajouter un item </strong></h1>
                    <hr>

                    <form class="form" role="form" action="insert.php" method="POST" enctype="multipart/form-data"> <!-- Action = Fichier destination de l'envoi par méthode POST -->

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
                            <input type="number"  class="form-control" id="year" name="year" placeholder="Année" value="<?php echo $year ?>">
                            <span class="help-inline"><?php echo $yearError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="miles">Kilométrage :</label>
                            <input type="number"  class="form-control" id="miles" name="miles" placeholder="Kilométrage" value="<?php echo $miles ?>">
                            <span class="help-inline"><?php echo $milesError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="miles">Motorisation :</label>
                            <input type="texte"  class="form-control" id="motorisation" name="motorisation" placeholder="motorisation" value="<?php echo $miles ?>">
                            <span class="help-inline"><?php echo $motorisationError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="category">Catégorie :</label>
                            <select class="form-control" id="category" name="category">
                                <?php 
                                    $db = Database::connect();
                                    foreach($db->query('SELECT * FROM categories') as $row)
                                    {
                                        echo '<option value="' . $row['name'] . '">' . $row['name'] .'</option>';
                                    }
                                    Database::disconnect();

                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError ?></span>
                        </div>


                        <div class="form-group">
                            <label for="img">Selectionner une image :</label>
                            <input type="file"  id="img" name="img">
                            <span class="help-inline"><?php echo $imgError ?></span>
                        </div>

                    

                    <div class="form-actions">
                        <a class="btn btn-danger" href="../index.php?page=2">Retour</a>
                        <button type="submit" class="btn btn-success" >Valider</button>
                    </div>

                    </form>

                </div>    
            </div>
        </div>
        
    </body>
</html>