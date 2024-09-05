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
    <!-- Inclusion de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="container">
    <a href="../index.php" class="btn btn-primary my-3">Accueil</a><br><br>

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
        p_s.name as size_name,    -- Récupère le nom de la taille
        p_b.name as base_name     -- Récupère le nom de la base
    FROM orders o
    JOIN cart_items ci ON o.cart_id = ci.cart_id
    JOIN dishes d ON ci.dish_id = d.dish_id
    LEFT JOIN pizzas_pates p_p ON d.pate_id = p_p.pizza_pate_id  -- Jointure pour les pâtes
    LEFT JOIN pizzas_sizes p_s ON d.size_id = p_s.pizza_size_id  -- Jointure pour les tailles
    LEFT JOIN pizzas_bases p_b ON d.base_id = p_b.pizza_base_id  -- Jointure pour les tailles
    ORDER BY o.order_id, d.name
";

        $query = $db->prepare($sql);
        $query->execute();
        $user_orders = $query->fetchAll(PDO::FETCH_ASSOC);

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

                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="thead-dark"><tr><th colspan="3">Commande n°'.$order['order_id'].'</th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td colspan="2">Date : '.$order['date_order'].'</td><td>Status : '.$order['order_status'].'</td></tr>';
            }

            // Afficher les informations du plat (quantité, nom, taille, pâte, base)
            echo '<tr>';
            echo '<td colspan="3"><strong>'.$order['dish_quantity'].' X '.$order['dish_name'].'</strong><br>';
            echo $order['size_name'].', '.$order['pate_name'].', '.$order['base_name'].'</td>';
            echo '</tr>';

            // Calcul du sous-total pour chaque plat
            $subtotal = $order['dish_price'] * $order['dish_quantity'];

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
            echo '<td colspan="3"><strong>Ingrédients : </strong>';
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
<!-- Inclusion de Bootstrap JS et jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>