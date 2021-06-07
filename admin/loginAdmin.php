<?php 
require 'connect.php'; // require interrompt le script si le fichier fait une erreur  

if(isset($_SESSION['id']) && isset($_SESSION['username']) ){
    
    echo '<script>window.location="index.php"</script>';
}

if(isset($_POST['connection']))
{

    $usernameConnect = checkInput($_POST['usernameConnect']);
    $passwordConnect = checkInput($_POST['passwordConnect']);
    
    if((!empty($usernameConnect)) && !empty($passwordConnect))
    {
        $db = Database::connect();
        $statement = $db->prepare('SELECT * FROM users WHERE user_username =?');

        $statement->bindValue(1, $usernameConnect, PDO::PARAM_STR);
        $statement->bindValue(2, $passwordConnect, PDO::PARAM_STR);

        $statement->execute(array($usernameConnect)); 

        $alreadyExist = $statement->rowCount(); // Compte le nombre de rangé qui éxiste avec la demande SQL
        $checkSuccess = $statement->fetch();

        if($alreadyExist == 1)
        {
            if(($usernameConnect == $checkSuccess['user_username']) && (password_verify($passwordConnect, $checkSuccess['user_password'])))
            {
             
                session_start();
                $_SESSION['id'] = $checkSuccess['id'];
                $_SESSION['username'] = $checkSuccess['user_username'];
                $_SESSION['admin'] = 1;

               echo '<script>window.location="index.php"</script>';

            }

        }else{
            $error = "Vous avez entré un pseudo ou mot de passe";
        }

    }else{
        $error = "Tous les champs doivent être complétés";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@600&display=swap" rel="stylesheet">
    <link href="../css/adminCustom.css" rel="stylesheet">
    <title>Administrateur</title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="offset-2 log-box col-8" >

            <div class="col-12 mb-2" style="text-align:center;">
                    <h3>Administration</h3>
                    <hr>
            </div>
                
            <div class="col-12" style="text-align:center;">
                <form method="POST" action="loginAdmin.php">  
                    <table class=" offset-2 col-sm-7">

                        <tr>
                            <td align="right">
                                <label for="username">Nom d'utilisateur   : </label>
                            </td>
                            <td>
                                <input type="texte" name="usernameConnect" placeholder="Votre pseudo">
                                <?php 
                                    if(isset($errorUsername)){
                                        echo '<span style="color:red;">'.$errorUsername.'</span>';
                                    }
                                ?>
                            </td>
                
                        </tr>

                        <tr>
                            <td align="right">
                                <label for="passwordConnect">Mot de passe : </label>
                            </td>
                                
                            <td>  
                                <input type="password" name="passwordConnect" placeholder="Votre mot de passe">
                                <?php 
                                    if(isset($errorPassword)){
                                        echo '<span style="color:red;">'.$errorPassword.'</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        
                    </table>

                    <div>
                        <a href="register.php">Mot de passe oublié?</a>
                    </div>
 
                    <a class="btn btn-danger mt-3"  href="../index.php" >Retour</a>
                    <button  class="btn btn-success mt-3" type="submit" name="connection" >Valider</button>
                    
                </form>
                <hr>
                <?php 
                    if(isset($error))
                    {
                        echo '<span style="color:red;">'.$error.'</span>';
                    }
                ?>
        
            </div>      
        </div>        
    </div>
</div> 



</body>
</html>