 <?php 
 
 $username = $_SESSION['username']; 
 
 ?>

 
 <div class="container-fluid">
    <div class="row">

        <div class="accueil col-12">
            <h1 class="col-sm-6 offset-3 mb-3 mt-3"><span>BIENVENUE <?php echo $username ?> </span></h1>
            <div class="col-12 d-flex">
                <img  class="col-6 img-fluid" alt="logo-du-garage" src="../assets/logoGF2.png">
                <video class="col-6" style="width:100%;" controls muted autoplay loop >
                        <source src="../videos/e208.mp4"
                                type="video/mp4">
                        ERREUR ! Votre navigateur ne supporte pas les vidéos.
                </video>
            </div>    
        </div>
    </div>
</div>

