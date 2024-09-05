<?php 
session_start();
$_SESSION['loggedIn'] = 1; // TEMP : Réglage temporaire pour indiquer l'état de connexion
$_SESSION['logged_user_id'] = 1; // TEMP : Réglage temporaire pour stocker l'ID de l'utilisateur connecté
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Affichage des commandes</title>
</head>

<body>
    <a href="../index.php">Accueil</a><br><br>

    <?php
        require_once('../php_sql/db_connect.php');

        // Requête SQL mise à jour pour récupérer les pates et tailles
        $sql = "
    SELECT 
        o.order_id, 
        o.date_order, 
        o.date_order, 
        o.order_status, 
        o.total, 
        d.dish_id,          -- Ajout de l'ID du plat
        d.name as dish_name, 
        d.price as dish_price, 
        ci.quantity as dish_quantity,
        p_p.name as pate_name,   -- Récupère le nom de la pâte
        p_s.name as size_name    -- Récupère le nom de la taille
    FROM orders o
    JOIN cart_items ci ON o.cart_id = ci.cart_id
    JOIN dishes d ON ci.dish_id = d.dish_id
    LEFT JOIN pizzas_pates p_p ON d.pate_id = p_p.pizza_pate_id  -- Jointure pour les pâtes
    LEFT JOIN pizzas_sizes p_s ON d.size_id = p_s.pizza_size_id  -- Jointure pour les tailles
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

            // Affichage des informations de pate et taille
            echo '<tr>';
            echo '<td colspan="4"><strong>Pâte :</strong> '.$order['pate_name'].'<br><strong>Taille :</strong> '.$order['size_name'].'</td>';
            echo '</tr>';

           // Récupérer les ingrédients pour le plat
           $dish_name = $order['dish_name'];
           $sql_ingredients = "
               SELECT i.name 
               FROM dish_ingredients di
               JOIN ingredients i ON di.ingredient_id = i.ingredient_id
               WHERE di.dish_name = :dish_name
           ";

           $query_ingredients = $db->prepare($sql_ingredients);
           $query_ingredients->bindValue(':dish_name', $dish_name);
           $query_ingredients->execute();
           $ingredients = $query_ingredients->fetchAll(PDO::FETCH_ASSOC);

           // Afficher les ingrédients
           echo '<tr>';
           echo '<td colspan="4">Pâte : '.$order['pate_name'].'<br>Taille : '.$order['size_name'].'<br>Ingrédients : ';
           $ingredient_names = array_column($ingredients, 'name');
           echo implode(', ', $ingredient_names);
           echo '</td>';
           echo '</tr>';
        }

        if ($current_order_id !== null) {
            echo '<tr><td colspan="3"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
            echo '</tbody></table>';
        }
    ?>
</body>

</html>