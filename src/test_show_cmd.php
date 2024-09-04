<?php 
session_start();
$_SESSION['loggedIn'] = 1; // TEMP : Réglage temporaire pour indiquer l'état de connexion
$_SESSION['logged_user_id'] = 1; // TEMP : Réglage temporaire pour stocker l'ID de l'utilisateur connecté
// echo ($_SESSION['loggedIn'] == 1) ? "Je suis connecté" : "Je suis PAS connecté"; // TEMP : Message pour vérifier l'état de connexion
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Affichage des commandes</title>
</head>

<body>
    <a href="index.php">Accueil</a><br><br>

    <?php
        require_once('php_sql/db_connect.php');

        $sql = "
            SELECT 
                o.order_id, 
                o.date_order, 
                o.order_status, 
                o.total, 
                d.name as dish_name, 
                d.price as dish_price, 
                ci.quantity as dish_quantity
            FROM orders o
            JOIN cart_items ci ON o.cart_id = ci.cart_id
            JOIN dishes d ON ci.dish_id = d.dish_id
            WHERE o.user_id = :user_id
            ORDER BY o.order_id, d.name
        ";

        $query = $db->prepare($sql);
        $query->bindValue(':user_id', $_SESSION['logged_user_id']);
        $query->execute();
        $user_orders = $query->fetchAll(PDO::FETCH_ASSOC);

        $current_order_id = null;

        foreach ($user_orders as $order) {
            if ($current_order_id !== $order['order_id']) {
                if ($current_order_id !== null) {
                    echo '<tr><td colspan="3"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
                    echo '</tbody></table><br><br><hr>';
                }
                $current_order_id = $order['order_id'];
                $previous_order_total = $order['total']; // stocker le total de la commande pour l'afficher plus tard

                echo '<h3>Commande n°'.$order['order_id'].'</h3>';
                echo '<table border="1" cellspacing="0" cellpadding="5">';
                echo '<thead><tr><th colspan="4">Informations Générales</th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td colspan="4">Date : '.$order['date_order'].'</td></tr>';
                echo '<tr><td colspan="4">Status : '.$order['order_status'].'</td></tr>';
                echo '<tr><td colspan="4">Détail de la commande :</td></tr>';
                echo '<tr><th>Nom du Plat</th><th>Prix Unitaire</th><th>Quantité</th><th>Sous-total</th></tr>';
            }

            $subtotal = $order['dish_price'] * $order['dish_quantity'];
            echo '<tr>';
            echo '<td>'.$order['dish_name'].'</td>';
            echo '<td>'.$order['dish_price'].'€</td>';
            echo '<td>'.$order['dish_quantity'].'</td>';
            echo '<td>'.$subtotal.'€</td>';
            echo '</tr>';
        }

        if ($current_order_id !== null) {
            echo '<tr><td colspan="3"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
            echo '</tbody></table>';
        }
    ?>
</body>

</html>





</body>

</html>