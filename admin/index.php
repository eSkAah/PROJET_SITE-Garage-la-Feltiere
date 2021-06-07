<?php 
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['admin'] == 1){

}else{
    
    echo '<script>window.location="loginAdmin.php"</script>';

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
    <title>Administrateur - <?php $titlePage ?> </title>
</head>

<body id="indexAdminBody">
    <!-- Ici on est sur la page index.php de la page Administrateur -->
  
    <div class="container-fluid">
        <div class="row">
            <div class="navbar col-sm-2 col-9">
                <div class="saisie mt-5 col-12">
                    <ul>
                        <li><a href="?page=1"><i class="fas fa-desktop"></i> Dashboard</a></li>
                        <br>
                        <li><a href="?page=2"><i class="fas fa-car"></i> Voitures en vente</a></li> <!-- Rajouter un menu DropDown si j'ai le temps en Javascript -->
                        <br>
                        <li><a href="?page=3"><i class="fas fa-car"></i> Voitures vendues</a></li>
                        <br>
                        <li><a href="?page=4"><i class="fas fa-user"></i> Liste des clients</a></li>
                        <br>
                        <li><a href="?page=5"><i class="fas fa-user-shield"></i></i> Liste des admins</a></li>
                        <br>
                        <li><a href="?page=6"><i class="fas fa-list"></i> Nos sélections</a></li>
                        <br>
                    </ul>

                    <div class="back">
                    <a href="../index.php"><i class="fas fa-backspace"></i> Vers le site</a>
                    </div>
                    <br>
                    <div class="col-12 disconnect">
                        <a href="../disconnect.php"><i class="far fa-times-circle"></i> Deconnexion</a>
                    </div> 
                </div>
            </div>

            <div class="mainPage col-sm-10 col-12">

                <?php

                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                
                    if($page == 1) {
                        include('Accueil.php');
                    }elseif($page == 2) {
                        include('usaCarAdmin.php');
                    }elseif($page == 3) {
                        include('soldCarAdmin.php');
                    }elseif($page == 4) {
                        include('clients.php');
                    }elseif($page == 5) {
                        include('users.php');
                    }elseif($page == 6) {
                        include('selections.php');
                    }
                }
                else {
                    include('Accueil.php');
                }

                ?>
        
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</body>

</html>