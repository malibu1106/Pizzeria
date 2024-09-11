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
    o.order_status, 
    o.total, 
    u.first_name, 
    u.last_name, 
    u.email,
    u.phone, 
    IF(ci.dish_id = 0, cp.custom_pizza_id, d.dish_id) as dish_id,   -- Utilisation de l'ID du plat ou de la pizza custom
    IF(ci.dish_id = 0, cp.name, d.name) as dish_name,               -- Nom du plat ou de la pizza custom
    IF(ci.dish_id = 0, cp.price, d.price) as dish_price,            -- Prix du plat ou de la pizza custom
    ci.quantity as dish_quantity,
    IF(ci.dish_id = 0, p_p.name, p_p2.name) as pate_name,           -- Nom de la pâte (pâte custom ou plat standard)
    IF(ci.dish_id = 0, p_s.name, p_s2.name) as size_name,           -- Nom de la taille (taille custom ou plat standard)
    IF(ci.dish_id = 0, p_b.name, p_b2.name) as base_name,           -- Nom de la base (base custom ou plat standard)
    IF(ci.dish_id = 0, 'custom', 'standard') as dish_type           -- Type custom ou standard
FROM orders o
JOIN cart_items ci ON o.cart_id = ci.cart_id
JOIN users u ON o.user_id = u.user_id   -- Jointure pour obtenir les informations du client

-- Jointures pour les plats standards
LEFT JOIN dishes d ON ci.dish_id = d.dish_id
LEFT JOIN pizzas_pates p_p2 ON d.pate_id = p_p2.pizza_pate_id
LEFT JOIN pizzas_sizes p_s2 ON d.size_id = p_s2.pizza_size_id
LEFT JOIN pizzas_bases p_b2 ON d.base_id = p_b2.pizza_base_id

-- Jointures pour les pizzas personnalisées
LEFT JOIN custom_pizzas cp ON ci.custom_pizza_id = cp.custom_pizza_id
LEFT JOIN pizzas_pates p_p ON cp.pate_id = p_p.pizza_pate_id
LEFT JOIN pizzas_sizes p_s ON cp.size_id = p_s.pizza_size_id
LEFT JOIN pizzas_bases p_b ON cp.base_id = p_b.pizza_base_id

ORDER BY o.order_id, dish_name
    ";

        $query = $db->prepare($sql);
        $query->execute();
        $user_orders = $query->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // print_r($user_orders);
        // echo '</pre>';

        $current_order_id = null;

        foreach ($user_orders as $order) {
            if ($current_order_id !== $order['order_id']) {
                // Afficher le total et clôturer la table de la commande précédente
                if ($current_order_id !== null) {
                    echo '<tr><td colspan="2"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
                    echo '</tbody></table><br><br>';
                }
                // Nouvelle commande, initialisation
                $current_order_id = $order['order_id'];
                $previous_order_total = $order['total']; // stocker le total de la commande pour l'afficher plus tard

                echo '<table border="1" cellspacing="0" cellpadding="5">';
                echo '<thead><tr><th colspan="3">Commande n°'.$order['order_id'].' - '.$order['first_name'].' '.$order['last_name'].'</th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td>Tel : '.$order['phone'].'</td><td colspan="2">Mail : '.$order['email'].'</td></tr>';
                echo '<tr><td colspan="2">Date : '.$order['date_order'].'</td><td>Status : '.$order['order_status'].'</td></tr>';
            }

            // Afficher les informations du plat (quantité, nom, taille, pâte, base)
            echo '<tr>';
            echo '<td colspan="3">'.$order['dish_quantity'].' X '.$order['dish_name'].' : '.$order['size_name'].', '.$order['pate_name'].', '.$order['base_name'].'</td>';
            echo '</tr>';

            // Calcul du sous-total pour chaque plat
            $subtotal = $order['dish_price'] * $order['dish_quantity'];

           // Vérifier si c'est une pizza custom
           if ($order['dish_type'] === 'custom') {
            // Récupérer les ingrédients pour la pizza personnalisée via custom_pizza_id
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
            // Récupérer les ingrédients pour un plat standard via dish_name
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
            // Afficher les ingrédients
            echo '<tr>';
            echo '<td colspan="3">';
            $ingredient_names = array_column($ingredients, 'name');
            echo implode(', ', $ingredient_names);
            echo '</td>';
            echo '</tr>';

            // Afficher le prix unitaire et le sous-total
            echo '<tr>';
            echo '<td>Prix Unitaire : '.$order['dish_price'].'€</td>';
            echo '<td colspan="2">Sous-total : '.$subtotal.'€</td>';
            echo '</tr>';
        }

        // Afficher le total de la dernière commande
        if ($current_order_id !== null) {
            echo '<tr><td colspan="2"><strong>Total</strong></td><td><strong>'.$previous_order_total.'€</strong></td></tr>';
            echo '</tbody></table>';
        }


        
    ?>
</body>

</html>