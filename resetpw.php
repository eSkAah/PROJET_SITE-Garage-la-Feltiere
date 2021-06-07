<?php
require 'admin/connect.php';

//Récupération du contenu de section, afin de modifier l'affichage du formulaire de la page
if(isset($_GET['section'])){
   $section = htmlspecialchars($_GET['section']);
}else{
   $section = "";
}



/*******************************************************************************************************/

// Vérification si formulaire de demande de réinitialisation mot de passe à été Submit
if(isset($_POST['recup_submit'], $_POST['recup_mail'])){

   // Vérification le contenu de l'input emal n'est pas vide
 if(!empty($_POST['recup_mail'])){

   // Netoyage des caractères html, et check validité du format Email
   $recup_mail = htmlspecialchars($_POST['recup_mail']);

   if(filter_var($recup_mail, FILTER_VALIDATE_EMAIL)){

      //Verifcation si mail éxiste en base de données
      //Connection a la base de données, j'ai crée une classe avec PDO dans le fichier connect.php 
      $bdd = Database::connect();

      $mailexist = $bdd->prepare('SELECT id, name FROM clients WHERE email = ?');
      $mailexist->execute(array($recup_mail));

      //Récupération du prénom de l'utilisateur pour le mail
      $name = $mailexist->fetch();
      $name = $name['name'];

      //On compte le nombe de ligne ou ce mail est contenu
      $mailexist_count = $mailexist->rowCount();

      if($mailexist_count == 1){
         // Stockage du mail das une SB $_SESSION
         $_SESSION['recup_mail'] = $recup_mail;

         //On génère un code secret a la main
         $recup_code = "" ;
         for ($i = 0; $i <= 8; $i++) { 
            $recup_code .= mt_rand(0,9) ;
         }

         //Création d'une table en base de données : recuperation
         
         //Vérification si le mail à déja récupérer une fois et est présent en BDD recuperation

         $mail_recup_exist = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ?');
         $mail_recup_exist->execute(array($recup_mail));
         $mail_recup_exist = $mail_recup_exist->rowCount();
         

         if($mail_recup_exist == 1) {
            //Mise à jour en base de données du code a l'adresse email éxistante
            $recup_insert = $bdd->prepare('UPDATE recuperation SET code = ? WHERE mail = ? ');
            $recup_insert->execute(array($recup_code, $recup_mail));

         }else{
      
            //Injection en base de données des informations email / code secret généré
            $recup_insert = $bdd->prepare('INSERT INTO recuperation(mail, code) VALUES (?,?) ');
            $recup_insert->execute(array($recup_mail, $recup_code));

         }

         // Contenu du mail à envoyer

         $header="MIME-Version: 1.0\r\n";
         $header.='From:"[Breuil Allan]"<allan.breuil@hotmail.fr>'."\n";
         $header.='Content-Type:text/html; charset="utf-8"'."\n";
         $header.='Content-Transfer-Encoding: 8bit';
         $message = '
         <html>
         <head>
           <title>Récupération de mot de passe - Garage de la Feltière</title>
           <meta charset="utf-8" />
         </head>
         <body>
           <font color="#303030";>
             <div align="center">
               <table width="600px">
                 <tr>
                   <td>
                     
                     <div align="center">Bonjour,' . $name .'</div>
                     Voici votre code de récupération: <b>'.$recup_code.'</b><br><br>
                     A bientôt sur <a href="#">Garage de la Feltière</a> !
                     
                   </td>
                 </tr>
                 <tr>
                   <td align="center">
                     <font size="2">
                       Ceci est un email automatique, merci de ne pas y répondre
                     </font>
                   </td>
                 </tr>
               </table>
             </div>
           </font>
         </body>
         </html>
         ';
         
         // Envoi de l'email à l'adresse entrée par l'utlisateur et vérifié / MODIFIER LE LOCALHOST par l'url du site **
         mail($_SESSION['recup_mail'], "Récupération de mot de passe - Garage de la Feltière", $message);
         Database::disconnect();
         
         echo '<script>window.location="http://bifrost-dev.fr/site_garage/index.php?page=10&section=code";</script>';
         
         //header("Location:http://bifrost-dev.fr/site_garage/index.php?page=10&section=code");  

      }else{
         //Erreur si l'email n'éxiste pas en base de données
         $error = "Cet adresse mail n'éxiste pas";
      }
      
   }else{
      //Erreur si le format de l'email est invalide
      $error = "Email invalide";
   }

 }else{
    //Erreur si l'input est vide
   $error = " Veuillez entrer votre adresse mail";
 }

}




/*******************************************************************************************************/

//Initlisation de la vérification du Token envoyé par mail, si le formulaire de verification a été submit
if(isset($_POST['verif_submit'], $_POST['verif_code'])){
   if(!empty($_POST['verif_code'])){ 
      //On stock le token entré par l'utilisateur dans une variable
      $verif_code = htmlspecialchars($_POST['verif_code']);

      //Connection a la base de donneé
      $bdd = Database::connect();

     
      
      //On selectionne dans la table récupération l'id de l'utilisateur ou l'email ET le code correspondent
      $verif_req = $bdd->prepare('SELECT id FROM recuperation WHERE mail = ? AND code = ?');
      $verif_req->execute(array($_SESSION['recup_mail'], $verif_code));

      //Vérification qu'il n'y a que un seul utilisateur qui correspond,et on est sur que c'est bien lui car le code unique généré correspond
      $verif_req = $verif_req->rowCount();

      //Si il y a bien un utlisateur unique qui est retrouvé, alors on supprime la ligne de la table
      if($verif_req == 1){
      //On passe confirm a 1 dans la base de données pour  valider le fait que l'utilisateur est bien passé par notre formulaire et à validé le token
      $up_req = $bdd->prepare('UPDATE recuperation SET confirm = 1 WHERE mail = ?');
      $up_req->execute(array($_SESSION['recup_mail']));

      //Redirection grâce a une variable dans l'url vers une page pour que l'utilisateur change son mot de passe
      echo '<script>window.location="http://bifrost-dev.fr/site_garage/index.php?page=10&section=changepw";</script>';
      
      //Sinon, on affiche une erreur
      }else{
         //var_dump($_SESSION['recup_mail']);
         //var_dump($verif_req);
         //var_dump($verif_code);
         
         $error = "Code invalide";
      }

      Database::disconnect();
   

   }else{
      $error = "Veuillez entrer votre code secret reçu par mail";
   }

}

/*******************************************************************************************************/

//Si le formulaire de changement de mot de passe à été submit alors, initialisation section de changement de mot de passe
if(isset($_POST['change_submit'])){

//verifier si l'utlisateur est bien passé par le lien de réinitialiastion mot de passe pour le modifier
$bdd = Database::connect();
$verif_confirm = $bdd->prepare('SELECT confirm FROM recuperation WHERE mail = ?');
$verif_confirm->execute(array($_SESSION['recup_mail']));
$verif_confirm = $verif_confirm->fetch();
$verif_confirm = $verif_confirm['confirm'];

if($verif_confirm == 1) {

   $pw = htmlspecialchars($_POST['change_pw']);
   $pwc = htmlspecialchars($_POST['change_pwc']);
   
   //Vérification que les champs ne soient pas vide
   if(!empty($pw) AND !empty($pwc)){
      if($pw == $pwc){
         //Si tout fonctionne alors on crypte le mot de passe
         $pw = password_hash($pw, PASSWORD_BCRYPT);

         //Puis on met à jour le mot de passe de l'utilisateur en base de données
         
         $update_bdd = $bdd->prepare('UPDATE clients SET password = ? WHERE email = ?');
         $update_bdd->execute(array($pw, $_SESSION['recup_mail']));

         $del_req = $bdd->prepare('DELETE FROM recuperation WHERE mail = ? ');
         $del_req->execute(array($_SESSION['recup_mail']));
         Database::disconnect();

         echo '<script>window.location="http://bifrost-dev.fr/site_garage/index.php?page=7";</script>'; 

         }else{
            $error = "Les mots de passe ne sont pas identique";
         }

      }else{
         $error = "Veuillez compléter tous les champs";
      }

   }else{
      $error = "Veuillez valider le code que vous avez reçu par mail";
   } 

}else{
   $error = "";
}


 
?>


<div class="container">

   <div class="row">
      <div class="col-12 mt-5 text-center">
         <h3>Récupération de mot de passe</h3>
         
         <hr style="border-color:white; width:50%;">
      </div>
   </div>

   <!-- Si on est dans la SECTION=CODE pour recevoir le TOKEN alors tu affiche le fomulaire de réinitliastion de mot de passe -->
   <?php if($section == "code"){    ?>
   <div class="row">
      <div class="col-12 mb-5  text-center">
      <div style="color:white">Veuillez entrer le code de vérification envoyer à l'adresse mail suivante:  <?php echo $_SESSION['recup_mail'] ?></div>;
      <form method="post">
         <input type="text" placeholder="Code de vérification" size="40" name="verif_code"/>
         <input  class="ml-2 btn btn-primary" type="submit" value="Valider" name="verif_submit"/>
         <hr style="border-color:white; width:50%;">
         <?php  if(isset($error)){ 
                     echo'<span style="color:red">' . $error . '</span>';
                  }else{ 
                     echo '<br>'; }  ?>
      </form>
      </div>
   </div>

   <!-- Sinon tu affiche la SECTION=changepw et le formulaire pour modifier le mot de passe -->
   <?php  }elseif($section == "changepw"){ ?>

   <div class="row">
      <div class="col-12 mb-5  text-center">
      <div style="color:white">Veuillez choisir votre nouveau mot de passe</div>;
      <form method="post">
         <input type="password" placeholder="Entrer votre mot de passe" size="40" name="change_pw"><br><br>
         <input type="password" placeholder="Confirmez votre mot de passe" size="40" name="change_pwc"><br><br>
         <input  class=" btn btn-primary" type="submit" value="Valider" name="change_submit">
         <hr style="border-color:white; width:50%;">
         <?php  if(isset($error)) {
             echo'<span style="color:red">' . $error . '</span>'; }else{ echo '<br>'; }  ?>
      </form>
      </div>
   </div>

   <!-- Si on est sur la page  réinitialisation mot de passe alors tu affiche le fomulaire qui demande le mail -->

   <?php }else{  ?>
         
   <div class="row">
      <div class="col-12 mb-5  text-center">
         <form method="post">
            <input type="email" placeholder="Entrez votre email" size="40" name="recup_mail"/>
            <input  class="ml-2 btn btn-primary" type="submit" value="Valider" name="recup_submit"/>
            <hr style="border-color:white; width:50%;">
         </form>
         <?php  if(isset($error)) { echo'<span style="color:red">' . $error . '</span>'; }else{ echo '<br>'; }  ?>

         <?php } ?>
      </div>
   </div>

</div>


