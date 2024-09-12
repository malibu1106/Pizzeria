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
    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/backoffice.css">
</head>

<body class="container my-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="../index.php" class="btn btn-primary">Retour au site</a>
        <a href="../back_office/backoffice.php" class="btn btn-primary">Accueil - Gestion</a>
    </div>
    <br><br>

    <div class="row">
        <!-- Début de la grille Bootstrap -->

        <?php
        require_once('../php_sql/db_connect.php');

        $sql = "
        SELECT 
    o.order_id, 
    o.date_order, 
    o.order_status, 
    o.total,
    o.payment_method, 
    u.first_name, 
    u.last_name, 
    u.email,
    u.phone, 
    IF(ci.dish_id = 0, cp.custom_pizza_id, d.dish_id) as dish_id,  
    IF(ci.dish_id = 0, cp.name, d.name) as dish_name,               
    IF(ci.dish_id = 0, cp.price, d.price) as dish_price,            
    ci.quantity as dish_quantity,
    IF(ci.dish_id = 0, p_p.name, p_p2.name) as pate_name,           
    IF(ci.dish_id = 0, p_s.name, p_s2.name) as size_name,           
    IF(ci.dish_id = 0, p_b.name, p_b2.name) as base_name,           
    IF(ci.dish_id = 0, 'custom', 'standard') as dish_type           
FROM orders o
JOIN cart_items ci ON o.cart_id = ci.cart_id
JOIN users u ON o.user_id = u.user_id  

LEFT JOIN dishes d ON ci.dish_id = d.dish_id
LEFT JOIN pizzas_pates p_p2 ON d.pate_id = p_p2.pizza_pate_id
LEFT JOIN pizzas_sizes p_s2 ON d.size_id = p_s2.pizza_size_id
LEFT JOIN pizzas_bases p_b2 ON d.base_id = p_b2.pizza_base_id

LEFT JOIN custom_pizzas cp ON ci.custom_pizza_id = cp.custom_pizza_id
LEFT JOIN pizzas_pates p_p ON cp.pate_id = p_p.pizza_pate_id
LEFT JOIN pizzas_sizes p_s ON cp.size_id = p_s.pizza_size_id
LEFT JOIN pizzas_bases p_b ON cp.base_id = p_b.pizza_base_id

WHERE o.order_status != 'archivée'  -- Exclure les commandes archivées

ORDER BY o.order_id, dish_name

    ";

        $query = $db->prepare($sql);
        $query->execute();
        $user_orders = $query->fetchAll(PDO::FETCH_ASSOC);

        $current_order_id = null;

        foreach ($user_orders as $order) {
            if ($current_order_id !== $order['order_id']) {
                if ($current_order_id !== null) {
                    echo '<tr><td colspan="2">Réglement : '.$previous_order_payment.'</td><td><strong>Total : '.$previous_order_total.'€</strong></td></tr>';
                    echo '</tbody></table><br><br>';
                    echo '</div>'; // Fin de la colonne
                }
                $current_order_id = $order['order_id'];
                $previous_order_total = $order['total'];
                $previous_order_payment = $order['payment_method'];  // Store the payment method of the current order

                // Nouvelle colonne pour chaque commande
                echo '<div class="col-12 col-md-6 mb-4">'; // Colonne qui prend 100% de la largeur sur petits écrans, et 50% sur les grands
                echo '<table class="table table-bordered">';
                echo '<thead class="table-dark"><tr><th colspan="3">
                <div class="d-flex justify-content-between">Commande n°'.$order['order_id'].' - '.$order['first_name'].' '.$order['last_name'].'
                    <div class="order_actions d-flex gap-2">
                        <a href=""><img src="../img/icons/order_edit_status.png" alt="éditer le status de la commande"></a>
                        <a href="print_order.php?order_id='.$order['order_id'].'"><img src="../img/icons/order_print.png" alt="imprimer la commande"></a>
                        <a href="archive_order.php?order_id='.$order['order_id'].'"><img src="../img/icons/order_delete.png" alt="supprimer la commande"></a>
                    </div>
                </div>
                </th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td>Tel : '.$order['phone'].'</td><td colspan="2">Mail : '.$order['email'].'</td></tr>';
                echo '<tr><td colspan="2">Date : '.$order['date_order'].'</td><td>Status : '.$order['order_status'].'</td></tr>';
            }

            echo '<tr>';
            echo '<td colspan="3">'.$order['dish_quantity'].' X '.$order['dish_name'].' : '.$order['size_name'].', '.$order['pate_name'].', '.$order['base_name'].'</td>';
            echo '</tr>';

            $subtotal = $order['dish_price'] * $order['dish_quantity'];

           if ($order['dish_type'] === 'custom') {
            $custom_pizza_id = $order['dish_id'];
            $sql_ingredients = "
               SELECT i.name 
               FROM custom_pizzas_ingredients cpi
               JOIN ingredients i ON cpi.ingredient_id = i.ingredient_id
               WHERE cpi.custom_pizza_id = :custom_pizza_id
           ";

            $query_ingredients = $db->prepare($sql_ingredients);
            $query_ingredients->bindValue(':custom_pizza_id', $custom_pizza_id);
            $query_ingredients->execute();
            $ingredients = $query_ingredients->fetchAll(PDO::FETCH_ASSOC);
        } else {
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
        }

            echo '<tr>';
            echo '<td colspan="3">';
            $ingredient_names = array_column($ingredients, 'name');
            echo implode(', ', $ingredient_names);
            echo '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Prix Unitaire : '.$order['dish_price'].'€</td>';
            echo '<td colspan="2">Sous-total : '.$subtotal.'€</td>';
            echo '</tr>';
        }

        if ($current_order_id !== null) {
            echo '<tr><td colspan="2">Réglement : '.$previous_order_payment.'</td><td><strong>Total : '.$previous_order_total.'€</strong></td></tr>';
            echo '</tbody></table>';
            echo '</div>'; // Fin de la dernière colonne
        }
    ?>
    </div> <!-- Fin de la grille Bootstrap -->
</body>

</html>