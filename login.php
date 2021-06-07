<?php 
require 'admin/connect.php'; // require interrompt le script si le fichier fait une erreur  


if(isset($_SESSION['id']) && isset($_SESSION['password'])){

echo '<script>window.location="index.php?page=9"</script>';

}

if(isset($_POST['connection']))
{

    $emailConnect    = checkInput($_POST['emailConnect']);
    $passwordConnect = checkInput($_POST['passwordConnect']);

    if((!empty($emailConnect)) && !empty($passwordConnect))
    {
        $db = Database::connect();

        $statement = $db->prepare('SELECT * FROM clients WHERE email =?');

        $statement->execute(array($emailConnect)); 
        
        $alreadyExist = $statement->rowCount(); // Compte le nombre de rangé qui éxiste avec la demande SQL
        $checkSuccess = $statement->fetch();

        if($alreadyExist == 1)
        {
            if(($emailConnect == $checkSuccess['email']) && (password_verify($passwordConnect, $checkSuccess['password'])))
            {

                $_SESSION['id'] = $checkSuccess['id'];
                $_SESSION['password'] = $checkSuccess['password'];

               echo '<script>window.location="index.php?page=9"</script>';

            }

        }else{
            $error = "Vous avez entré un mauvais mail ou mot de passe";
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

<body>
<div class="mb-5 container">
    <div class="row">
        <div class="col-12 mt-5 mb-5" style="text-align:center;">
            <h3>SE CONNECTER</h3>
            <hr style="border-color:white; width:50%;">
        </div>
        
        <div class="col-12" style="text-align:center;">
            <form method="POST" action="index.php?page=7">  
                <div>
                    <label for="emailConnect">Votre adresse mail : </label>
                    <input type="texte" name="emailConnect" placeholder="Votre adresse email">
                    <div>
                    <?php 
                        if(isset($errorMail)){
                            echo '<span style="color:red;">'.$errorMail.'</span>';
                        }
                    ?>
                    </div>
                </div>
                <div>
                    <label for="passwordConnect">Votre mot de passe : </label>
                    <input type="password" name="passwordConnect" placeholder="Votre mot de passe">
                </div>
                <div>
                    <?php 
                        if(isset($errorPassword)){
                            echo '<span style="color:red;">'.$errorPassword.'</span>';
                        }
                    ?>
                </div>
                <div class="mt-2 mb-1">
                    <a href="index.php?page=8">S'inscrire</a><br>
                    <a href="index.php?page=10">Mot de passe oublié?</a>
                </div>
                
                <a class="btn btn-danger mt-3"  href="index.php" >Retour</a>
                <button  class="btn btn-success mt-3" type="submit" name="connection" >Valider</button>
                
            </form>
            <hr style="border-color:white; width:50%;">
            <?php 
                if(isset($error))
                {
                    echo '<span style="color:red;">'.$error.'</span>';
                }

                ?>
            
            
        </div>      
    </div>
</div> 



</body>
</html>