<?php 
/*  To do : 
   -On récupère les infos du form et je stock dans les variables
   -initialise le variable isSucces, si elle reste True alors tu envois
   -Vérification si $_POST est vide, et check si un champs à été laissé vide
   -Si un champ est vide, tu passe $isSuccess à False
   -Si tout est bon, tu check avec $isSuccess est true, et si il est true tu envoi l'email */


$name = $email = $tel = $adress = $title = $message = $nameError = $emailError = $telError = $adressError = $titleError = $messageError  = "";

if(!empty($_POST) )
{
 // Vérification et suppresion des caractères spéciaux se trouvant dans les Inputs
  $name = checkInput($_POST['name']);
  $email = checkInput($_POST['email']);
  $tel = checkInput($_POST['tel']);
  $adress = checkInput($_POST['adress']);
  $title = checkInput($_POST['title']);
  $message = checkInput($_POST['message']);
  $isSuccess = true;

// Verification si les champs ne sont pas vide, sinon message d'erreur
  if(empty($name)){
    $nameError = "Vous ne pouvez pas laisser ce champ vide";
    $isSuccess = false;
  }
  if(empty($email)){
    $emailError = "Vous ne pouvez pas laisser ce champ vide";
    $isSuccess = false;
  }
  if(empty($tel)){
    $telError = "Vous ne pouvez pas laisser ce champ vide";
    $isSuccess = false;
  }
  if(empty($adress)){
    $adressError = "Vous ne pouvez pas laisser ce champ vide";
    $isSuccess = false;
  }
  if(empty($title)){
    $titleError = "Vous ne pouvez pas laisser ce champ vide";
    $isSuccess = false;
  }
  if(empty($message)){
    $messageError = "Vous ne pouvez pas laisser ce champ vide";
    $isSuccess = false;
  }
 
  if($isSuccess){

      $to = "allan.breuil@hotmail.fr";
      $body = "";
    
      $body .= "From : " . $name . "\r\n"; // Retour ligne + saut de ligne
      echo '<br>';
      $body .= "Email : " . $email . "\r\n";
      echo '<br>';
      $body .= "Message : " . $message . "\r\n";
    
      mail($to, $title, $body);
    
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

<img class="img-fluid" alt="responsive image" src="images/transition.png" >
  
  <div class="container">
    <div class="row">
    <div class="title col-12 mt-3 mb-3">
            <h3><span>CONTACTEZ NOUS :</span></h3>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3 col-12 mt-2 mb-2" style="text-align:center;">
          <h4 class="title" style="text-align:center;">CONTACT : </h4>  <br>
            <p style="color:white;">Garage De La Feltiere<br>
            17 Boucle Des Dinandiers.<br>
            57290 FAMECK<br>
          <br>
            Mail: <br>
            contact@garagedelafeltiere.com<br>
            Standard : <br>
            +33 (0)3 82 59 90 39<br>
            Service Commercial : <br>
            +33 (0)6 08 92 19 09<br></p>
          <div class="formLogo mt-4">
            <img src="images/logoGF.png">
          </div>
        </div>


        <div class="col-md-8 offset-1 col-9  mt-2 mb-2">
          <form class="form" action="?page=6" method="POST">
                    
            <div class="form-group">               
              <input type="text" class="form-control" id="name" name="name" size="20" placeholder="* Votre Nom">
              <span class="help-inline"><?php echo $nameError ?></span>
            </div>

            <div class="form-group">               
              <input type="text" class="form-control" id="email" name="email" placeholder="* Votre Email">
              <span class="help-inline"><?php echo $emailError ?></span>
            </div>

            <div class="form-group">               
              <input type="text" class="form-control" id="tel" name="tel" placeholder="* Votre numéro de téléphone">
              <span class="help-inline"><?php echo $telError ?></span>
            </div>

            <div class="form-group">                
              <input type="text" class="form-control " id="adress" name="adress" placeholder="* N° / Nom de rue / Code Postal / Ville">
              <span class="help-inline"><?php echo $adressError ?></span>
            </div>

            <div class="form-group">               
              <input type="text" class="form-control" id="title" name="title" placeholder="* Titre">
              <span class="help-inline"><?php echo $titleError ?></span>
            </div>

            <div class="form-group">               
              <textarea type="textarea" rows="10" class="form-control" id="message" name="message" placeholder="* Sujet"></textarea>
              <span class="help-inline"><?php echo $messageError ?></span>
            </div>
            
            <button class="mt-3 mb-3  btn btn-primary"  id="form-submit" type="submit">Envoyer</button>
            
            </form> 
        </div>    
        <hr>
          
    </div>
  </div>  


