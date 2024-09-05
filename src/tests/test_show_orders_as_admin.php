<?php 
session_start();
$_SESSION['loggedIn'] = 1; // TEMP : Réglage temporaire pour indiquer l'état de connexion
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Affichage des commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <a href="../index.php" class="btn btn-primary mb-4">Accueil</a>

        <?php
            require_once('../php_sql/db_connect.php');

            // Requête pour récupérer toutes les commandes de tous les utilisateurs
            $sql = "
                SELECT 
                    o.order_id, 
                    o.date_order, 
                    o.order_status, 
                    o.total, 
                    d.name as dish_name, 
                    d.price as dish_price, 
                    ci.quantity as dish_quantity,
                    u.last_name as user_name  -- Récupérer le nom d'utilisateur
                FROM orders o
                JOIN cart_items ci ON o.cart_id = ci.cart_id
                JOIN dishes d ON ci.dish_id = d.dish_id
                JOIN users u ON o.user_id = u.user_id  -- Associer la table des utilisateurs
                ORDER BY o.order_id, d.name
            ";

            $query = $db->prepare($sql);
            $query->execute();
            $all_orders = $query->fetchAll(PDO::FETCH_ASSOC);

            $current_order_id = null;

            // Boucle pour afficher toutes les commandes
            foreach ($all_orders as $order) {
                if ($current_order_id !== $order['order_id']) {
                    if ($current_order_id !== null) {
                        // Afficher le total de la commande précédente
                        echo '<tr><td colspan="3"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
                        echo '</tbody></table><hr class="my-4">';
                    }
                    $current_order_id = $order['order_id'];
                    $previous_order_total = $order['total'];

                    // Afficher les informations générales de la commande
                    echo '<h3 class="mb-3">Commande n°'.$order['order_id'].' - Utilisateur : '.$order['user_name'].'</h3>';
                    echo '<table class="table table-bordered">';
                    echo '<thead class="table-light"><tr><th colspan="4">Informations Générales</th></tr></thead>';
                    echo '<tbody>';
                    echo '<tr><td colspan="4"><strong>Date :</strong> '.$order['date_order'].'</td></tr>';
                    echo '<tr><td colspan="4"><strong>Status :</strong> '.$order['order_status'].'</td></tr>';
                    echo '<tr><td colspan="4"><strong>Détail de la commande :</strong></td></tr>';
                    echo '<tr><th>Nom du Plat</th><th>Prix Unitaire</th><th>Quantité</th><th>Sous-total</th></tr>';
                }

                // Afficher chaque plat de la commande
                $subtotal = $order['dish_price'] * $order['dish_quantity'];
                echo '<tr>';
                echo '<td>'.$order['dish_name'].'</td>';
                echo '<td>'.$order['dish_price'].'€</td>';
                echo '<td>'.$order['dish_quantity'].'</td>';
                echo '<td>'.$subtotal.'€</td>';
                echo '</tr>';
            }

            // Si une commande est toujours en cours d'affichage
            if ($current_order_id !== null) {
                echo '<tr><td colspan="3"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
                echo '</tbody></table>';
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>