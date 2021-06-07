
<h1 class="col-sm-6 offset-3 mb-4 mt-3"><span>ADMINISTRATEURS</span></h1>
<div class="container-fluid admin">
    <div class="row">
        <div class="col-sm-12 text-center">
            <a href="users/insert_user.php" class="btn btn-success btn-lg"><i class="fas fa-plus"></i><strong> AJOUTER ADMINISTRATEUR</strong></a>
        </div>
        <table class="table table-striped table-dark mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Identifiant</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                require 'connect.php';
                $classement = 'user_surname';

                $db = Database::connect();
                
                $statement = $db->query('SELECT * FROM users ORDER BY '.$classement. '');
                while($item = $statement->fetch())
                {

                echo '<tr>';
                    echo '<td>' . $item['user_surname'] . '</td>';
                    echo '<td>' . $item['user_name'] . '</td>';
                    echo '<td>' . $item['user_username'] . '</td>';
                    echo '<td>' . $item['user_type'] . '</td>';

                    echo '<td width=450 >';
                        echo '<a class="mr-2 btn btn-primary" href="clients/view_clients.php?id='. $item['id'] . '">Modifier permissions</a>';
                    echo ' ';
                        echo '<a class="btn btn-danger" href="users/delete_user.php?id=' . $item['id'] . '">Supprimer</a>';
                    echo '</td>';
                echo '</tr>';

                }
                Database::disconnect();

                ?>

            </tbody>
        </table>
    </div>
</div>     
