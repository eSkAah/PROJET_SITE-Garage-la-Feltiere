<?php 
    require '../connect.php';

    $nameError = $surnameError = $usernameError = $typeError  = $passwordError = $name = $surname = $username = $type  = $password = " ";
    if(!empty($_POST))
    {
        $surname    = checkInput($_POST['surname']);
        $name       = checkInput($_POST['name']);
        $username   = checkInput($_POST['username']);
        $password   = password_hash(checkInput($_POST['password']), PASSWORD_BCRYPT);
        $type       = checkInput($_POST['type']);
        
        $isSuccess  = true;
      

        // Si tous les champs sont remplis, alors isSuccess sera TRUE, donc on insert dans la BDD puis on deconnect de la BDD
        if($isSuccess)
        {
            $db = Database::connect();

            $statement = $db->prepare("INSERT INTO users (user_surname, user_name, user_username, user_password, user_type ) values (?,?,?,?,?)");
            $statement->execute(array($surname,$name,$username,$password,$type));
            
            Database::disconnect();

            echo '<script> window.location = "../index.php?page=5"</script>';
            
        }

    }


// Securité
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
            <title>Ajouter du contenu </title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="mt-5 p-5 offset-3 col-sm-6 bg-light rounded">
                    <h1><strong>Ajouter un Admin </strong></h1>
                    <hr>

                    <form class="form" role="form" action="insert_user.php" method="POST"> <!-- Action = Fichier destination de l'envoi par méthode POST -->

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
                            <label for="username">Identifiant :</label>
                            <input type="texte"  class="form-control" name="username"  value="<?php echo $username ?>">
                            <span class="help-inline"><?php echo $usernameError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password :</label>
                            <input type="texte"  class="form-control"  name="password"  value="<?php echo $password ?>">
                            <span class="help-inline"><?php echo $passwordError ?></span>
                        </div>

                        <div class="form-group">
                            <label for="type">Rôle :</label>
                            <select  class="form-control" name="type">
                                <option value="Boss">Boss</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <span class="help-inline"><?php echo $typeError ?></span>
                        </div>
                  

                    <div class="form-actions">
                        <a class="btn btn-danger" href="../index.php?page=5">Retour</a>
                        <button type="submit" class="btn btn-success" >Valider</button>
                    </div>

                    </form>

                </div>    
            </div>
        </div>
        
    </body>
</html>