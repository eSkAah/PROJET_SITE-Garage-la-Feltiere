<?php 
require 'connect.php';

//  $table = [tableau des 4 var]
$selected = [];

$db = Database::connect();

$q = 'SELECT * FROM items WHERE active_item = 1';

$stm = $db->query($q);


while($itm = $stm->fetch()){
    array_push($selected, $itm['id']);
}


if(!empty($_POST)){

    // Nouvelles voitures sélectionnés

$selected = [
    $_POST['selectionCar1'],
    $_POST['selectionCar2'],
    $_POST['selectionCar3'],
    $_POST['selectionCar4']
];

//var_dump($selected);

$db = Database::connect();

$query = 'SELECT * FROM items';

$stm = $db->query($query);
$item = $stm->fetchAll();
//var_dump($item);
        
for($i = 0; $i<count($item); $i++){

    
    $itm = $item[$i]['id'];
    $itmActive = $item[$i]['active_item'];
    //var_dump($selected); 
    //echo $itm.'<br>';
    //echo $itmActive.'<br>';

        if(in_array($itm, $selected) && $itmActive == 0){

            //echo'oui<br>';
            //echo $itm.'-';
            //echo $selected[$y].'<br>';

            $q = 'UPDATE items SET active_item = 1 WHERE id = :id';
            $data = [
                'id' => $itm
            ];

            $stm = $db->prepare($q);
            $stm->execute($data);

        }elseif(in_array($itm, $selected) && $itmActive == 1){
            //echo "déja en Selected";
            //echo $itm.'-';
            continue;

        }else{

            //echo 'NON';

            $q = 'UPDATE items SET active_item = 0 WHERE id = :id';

            $data = [
                'id' => $itm
            ];

            $stm = $db->prepare($q);
            $stm->execute($data);
           
        }

}

};


// Select ID from ITEMS WHERE active_item = 1 et stock dans la variable   $item['id]
// Boucle FOR x4 sur chaques items trouvés

// Si ID trouvé dans la BDD != des ID recu par le formulaire alors tu UPDATE active_item = 0
// Sinon, tu UPDATE active_item = 1

?>

<h1 class="col-sm-4 offset-sm-4 col-12 mb-3 mt-3"><span>Nos sélections</span></h1>
<div class="container-fluid admin">
    <div class="row">
        <p class="col-sm-12 text-center">Sélectionnez dans les menus déroulant ci-dessous les véhicules que vous souhaitez mettre en avant sur
            votre site. </p>  
    </div>

    <form class="col-12 mt-5 form" method="POST" action="index.php?page=6">
    <div class="row">

<?php


$db = Database::connect();
$q = 'SELECT * FROM items WHERE category = "voitures" ORDER BY id DESC';

for( $i = 1; $i < 5; $i++) {

    echo '<div class="col-12 col-sm-3 mb-3">';
    echo '<h4 class="text-center">Sélection '. $i .'</h4>'; 

    echo '<select class="form-control" id="selectionCar" name="selectionCar'. $i .'">';


    foreach($db->query($q) as $row)
    {
        
        if($row['id'] == $selected[$i] && $row['active_item'] == 1){
            echo '<option selected="selected" value="' . $row['id'] . '">' . $row['description'] .'</option>';
        }else{
            echo '<option value="' . $row['id'] . '">' . $row['description'] .'</option>';
        }

    }

    echo '<option selected="selected" value="">Choisissez un véhicule</option>';

    
    Database::disconnect();
    echo '</select>';
    echo '</div>';

}


$db = Database::connect();

$q = 'SELECT * FROM items WHERE active_item = 1';

$stm = $db->query($q);
$itm = $stm->fetchAll();

//var_dump($itm);

$val1 = count($itm);
$val2 = 4 - $val1;

for($i = 0 ; $i < $val1 ; $i++){

            echo '<div class="ourSelectBox  mt-2 col-12 col-sm-3">';
            echo      '<div class="img-thumbnail">';
            echo          '<img src="../images/voitures/' . $itm[$i]['img'] . '">';
            echo          '<div class="mt-1 mb-2 ">Prix :<br>' . $itm[$i]['price'] . ' €</div>';
            echo          '<div class="caption">';
            echo          '<p>Véhicule :<br>' . $itm[$i]['description'] . '</p>';
            echo          '<p>Kilométrage :<br>' . $itm[$i]['miles'] . 'km</p>';
            echo          '</div>';
            echo      '</div>';
            echo '</div><br>';
}       
            
for($i = 0 ; $i < $val2 ; $i++){
   
            echo '<div class="ourSelectBox  mt-2 col-12 col-sm-3">';
            echo      '<div class="pb-5 img-thumbnail">';
            echo          '<img src="../images/peugeot-logo-2021.jpg">';
            echo      '</div>';
            echo '</div><br>';

}
           
    
?>
        <button class="mt-2 col-2 offset-3 btn btn-primary">Remettre à zéro</button>
        <button class="mt-2 col-2 offset-1 btn btn-success" type="submit">Valider</button>
        


    </form>

    </div>
</div>     
