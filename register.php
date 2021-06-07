<?php 
require 'admin/connect.php';

if(isset($_POST['inscription'])) 
{
    if((!empty($_POST['surname'])) && 
    (!empty($_POST['name'])) && 
    (!empty($_POST['email'])) &&
    (!empty($_POST['address'])) &&
    (!empty($_POST['zip'])) &&
    (!empty($_POST['city'])) && 
    (!empty($_POST['emailCheck'])) &&
    (!empty($_POST['password'])) &&
    (!empty($_POST['passwordCheck']))) 
    {   
        $surname        = checkInput($_POST['surname']);
        $name           = checkInput($_POST['name']);
        $address        = checkInput($_POST['address']);
        $zip            = checkInput($_POST['zip']);
        $city           = checkInput($_POST['city']);
        $email          = checkInput($_POST['email']);
        $emailCheck     = checkInput($_POST['emailCheck']);
        $password       = checkInput($_POST['password']); // Hashage du password qui apparait hasher dans la BDD
        $passwordCheck  = checkInput($_POST['passwordCheck']);
        $surname        = checkInput($_POST['surname']);
        $isSuccess      = false;
        
        if(filter_var($email, $filter = FILTER_VALIDATE_EMAIL)) // Securisation de mail pour le valider, et éviter que quelqu'un envoi du text
        {

            if(($password !== $passwordCheck) && ($email !== $emailCheck)) // Si les mails et MDP sont raté tous les deux
            {
                $errorPassword = "Vos mots de passe ne correspondent pas";
                $errorMail = "Vos emails ne correspondent pas";
    
            }elseif($email !== $emailCheck) // Si Emails et mdp ne sont pas raté tous les deux, mais que email oui 
            {
                $errorMail = "Vos emails ne correspondent pas";
    
            }
            elseif(($password !== $passwordCheck)) // Si emails Ok, et que les deux ne sont pas raté mais que Password est raté
            {
                $errorPassword = "Vos mots de passe ne correspondent pas";
            }else // Si tout passe, alors tu "insert" dans la BDD
            {
                $userPassword = password_hash($password, PASSWORD_BCRYPT);

                $db =  Database::connect();

                $statement = $db->prepare("INSERT INTO clients ( name, surname, email, password, address, zip, city) values (?,?,?,?,?,?,?)");
                    $statement->bindValue(1, $name, PDO::PARAM_STR);
                    $statement->bindValue(2, $surname, PDO::PARAM_STR);
                    $statement->bindValue(3, $email, PDO::PARAM_STR);
                    $statement->bindValue(6, $userPassword, PDO::PARAM_STR);
                    $statement->bindValue(4, $address, PDO::PARAM_STR);
                    $statement->bindValue(5, $zip, PDO::PARAM_INT);
                    $statement->bindValue(7, $city, PDO::PARAM_STR);

                $statement->execute(array($name, $surname, $email, $userPassword, $address, $zip, $city ));
                



                Database::disconnect();

                $to = $email;
                $title = "Votre compte GARAGE LA FELTIERE à bien été crée. ";
                $body="";
                $message = "Bienvenue, vous pouvez desormais vous connecter à votre espace personnel, et y retrouver toutes les informations concernant vos véhicules, ainsi que vos différentes factures";
                
                $body .= "From : garage_la_feltiere@gmail.com\r\n\n"; // Retour ligne + saut de ligne
                $body .=  $message . "\r\n\n";
                $body .= "Pour vous connecter au compte, vous devrez utiliser cet adresse mail : " . $email . "\r\n\n";
                $body .= "L'équite du GARAGE LA FELTIERE vous souhaite de passer une agréable journée.";
                
                
                mail($to, $title, $body);


                $isSuccess = true;
                $error = '<span style="color:green;">Votre inscription à bien été enregistrée</span>';
                echo '<script> window.location = index.php</script>';
            }

        }else{
            $errorMail = " Mail Invalide";
        }
    }else
    {
        $error = '<span style="color:red;">Tous les champs doivent être complétés</span>';
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

<div class="container">
    <div class="row">
        <div class="offset-2 col-sm-8 mt-5 mb-4" style="text-align:center;">
            <h3>FORMULAIRE D'INSCRIPTION</h3>
            <hr class="separator">
            <?php 
            if(isset($error))
            {
                echo $error; 
            }     
            ?>
        </div>
        
        <div class="offset-3 col-sm-10 mb-5">
            
            <form method="POST" action="index.php?page=8.php">
                <table>
                    <tr>
                        <td>
                            <label for="surname">Entre votre Nom : </label>
                        </td>
                        <td>
                            <input type="text" size="35px" name="surname" placeholder="*Votre nom">
                        </td>
                    </tr>
                        
                    <tr>
                        <td>
                            <label for="name">Entre votre Prénom : </label>
                        </td>
                        <td>
                            <input type="text" size="35px" name="name" placeholder="*Votre prenom">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="address">Entre votre adresse : </label>
                        </td>
                        <td>
                            <input type="text" size="35px" name="address" placeholder="*Numéro et Nom de rue">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="zip">Entre votre code postale: </label>
                        </td>
                        <td>
                            <input type="text" size="35px" name="zip" placeholder="*Votre code postale">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="city">Entre le nom de votre Ville : </label>
                        </td>
                        <td>
                            <input type="text" size="35px" name="city" placeholder="*Votre ville">
                        </td>
                    </tr>
                
                    <tr>
                        <td>
                            <label for="email">Entrez votre adresse Email :   </label>
                        </td>
                        <td>
                            <input type="text" name="email" size="35px" placeholder="*Votre adresse Email">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="emailCheck">Confirmez votre adresse Email :   </label>
                        </td>
                        <td>
                            <input type="text" name="emailCheck" size="35px" placeholder="*Confirmez adresse Email">
                            <?php 
                            if(isset($errorMail)){
                                echo '<span style="color:red;">'.$errorMail.'</span>';
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="password">Choisissez un mot de pass : </label>
                        </td>
                        <td>
                            <input type="password" size="35px"  name="password" placeholder="*Votre mot de pass">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label for="passwordCheck">Retappez votre mot de pass : </label>
                        </td>
                        <td>
                            <input type="password" size="35px" name="passwordCheck" placeholder="*Retapez mot de pass">
                            <?php 
                            if(isset($errorPassword)){
                                echo '<span style="color:red;">'.$errorPassword.'</span>';
                            }
                            ?>
                        </td>
                    </tr>       
                </table>
                    <a class="mt-3 btn btn-danger"  href="index.php" >Retour</a>
                    <button class="mt-3 btn btn-success" type="submit" name="inscription">Valider</button>
            </form>
            
            
        </div>      
    </div>
</div>


