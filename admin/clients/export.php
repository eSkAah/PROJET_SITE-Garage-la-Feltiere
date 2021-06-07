<?php 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="client-export.csv"');

    require '../connect.php';

    $db = Database::connect();

    $q = 'SELECT * FROM clients';

    $stm = $db->prepare($q);
    $stm->execute();
    $data = $stm->fetchAll();

?>
"name";"surname";"email";"ville";
<?php

    foreach($data as $q) {

        echo $q['name'] . ";" . $q['surname'] . ";" . $q['email'] . ";" . $q['city'] . "\n";
    }
?>
    


    