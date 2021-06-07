
<h1 class="col-sm-2 offset-5 mb-4 mt-3"><span> CLIENTS</span></h1>
<div class="container-fluid admin">
    <div class="row">
        <div class="col-sm-12 text-center">
            <a href="clients/insert_clients.php" class="btn btn-success btn-lg"><i class="fas fa-plus"></i> AJOUTER CLIENT</a>
            <a href="clients/export.php" class="ml-5 btn btn-info "> EXPORTATION CLIENTS</a>

        </div>
        <table class="table table-dark table-borderless mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody class="col-12">

                <?php
                require 'connect.php';
                $classement = 'surname';

                $db = Database::connect();
                
                $statement = $db->query('SELECT * FROM clients ORDER BY '.$classement. '');
                while($item = $statement->fetch())
                {

                echo '<tr>';
                    echo '<td>' . $item['surname'] . '</td>';
                    echo '<td>' . $item['name'] . '</td>';
                    echo '<td>' . $item['email'] . '</td>';
                    echo '<td>' . $item['address'] . '</td>';
                    echo '<td>' . $item['city'] . '</td>';
                    
                    
                    echo '<td width=500 >';
                        echo '<a class="btn-sm btn-light" href="clients/view_clients.php?id='. $item['id'] . '">Fiche client</a>';
                    echo ' ';
                        echo '<a class="btn-sm btn-success" href="clients_items/view_ci.php?id='. $item['id'] . '">Véhicules</a>';
                    echo ' ';
                        echo '<a class="btn-sm btn-primary" href="clients/update_clients.php?id=' . $item['id'] . '">Modifier</a>';
                    echo ' ';
                    echo '<br\>';
                        echo '<a class="btn-sm btn-danger" href="clients/delete_clients.php?id=' . $item['id'] . '">Supprimer</a>';
                    echo '</td>';
                echo '</tr>';

                }
                Database::disconnect();

                ?>

            </tbody>
        </table>
    </div>
</div>     
