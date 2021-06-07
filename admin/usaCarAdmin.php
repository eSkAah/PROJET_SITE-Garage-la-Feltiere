
<h1 class="col-sm-6 offset-3 mb-4 mt-3"><span>VÉHICULES EN VENTE</span></h1>
<div class="container-fluid admin">
    <div class="row">
        <div class="col-12 text-center">
            <a  href="voitures/insert.php" class="btn btn-success btn-lg"><i class="fas fa-plus"></i></span><strong> AJOUTER VEHICULE</strong></a>
        </div>
        <table class="table table-striped table-dark mt-4">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Description</th>
                    <th>Prix (€)</th>
                    <th>Kilométrage</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                require 'connect.php';
                $db = Database::connect();
                
                $statement = $db->query('SELECT * 
                                            FROM items 
                                            WHERE category = "voitures"
                                            ORDER BY description ASC
                                        ');
                while($item = $statement->fetch())
                {

                echo '<tr>';
                    echo '<td><img class="photo-from-list"  src="../images/'.$item['category'].'/' . $item['img'] .'"></td>';
                    echo '<td>' . mb_strimwidth($item['description'], 0, 20, '...'). '</td>';
                    echo '<td>' . number_format((float)$item['price'],2,'.',',') . '</td>';
                    echo '<td>' . $item['miles'] . ' km</td>';

                    echo '<td width=400 >';
                        echo '<a class="btn-sm btn-light" href="voitures/view.php?id='. $item['id'] . '"><i class="far fa-eye"></i>Voir</a>';
                    echo ' ';
                        echo '<a class="btn-sm btn-primary" href="voitures/update.php?id=' . $item['id'] . '"><i class="fas fa-undo"></i>Modifier</a>';
                    echo ' ';
                        echo '<a class="btn-sm btn-info" href="voitures/sold.php?id=' . $item['id'] . '"><i class="fas fa-undo"></i>Vendu</a>';
                    echo ' ';
                        echo '<a class="btn-sm btn-danger" href="voitures/delete.php?id=' . $item['id'] . '"><i class="far fa-trash-alt"></i></a>';
                    echo '</td>';
                echo '</tr>';

                }
                Database::disconnect();

                ?>

            </tbody>
        </table>
    </div>
</div>     
